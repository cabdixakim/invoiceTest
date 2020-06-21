<?php

namespace App\Jobs;

use App\Payment;
use App\Receipt;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use LaravelDaily\Invoices\Invoice;
// classes from controller
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use LaravelDaily\Invoices\Classes\Party;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class ReceiptPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $payment;

    public function __construct(Payment $payment)
    {
        //
        $this->payment = $payment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $client = new Party([
            'name'          => $this->payment->student_name,
            'address'       => $this->payment->student_id,
        ]);

        $customer = new Party([
            'name'          => $this->payment->sponsor_name,
            'address'       => $this->payment->sponsor_id,
            
            
        ]);

        $item =  (new InvoiceItem())->title($this->payment->student_name.Str::random(5))->subTotalPrice(50000.00);

        $notes = $this->payment->status;

        $invoice = Invoice::make('receipt')
            ->series('NOO')
            ->sequence(876)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date($this->payment->created_at)
            ->dateFormat('m/d/Y')
            ->currencySymbol('$')
            ->currencyCode('USD')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator(',')
            ->currencyDecimalPoint('.')
            ->filename($this->payment->student_name.'-'.Str::random(5).'-'.$this->payment->sponsor_name.'-'.Str::random(3))
            ->addItem($item)
            ->notes($notes)
            ->logo(public_path('vendor/invoices/sample-logo.png'))
            // You can additionally save generated invoice to configured disk
            ->save('public');
            
        $link = $invoice->url();
        // Then send email to party with link
          $receipt = Receipt::firstOrcreate([
              'url'=> $link,
          ]);
    }
}
