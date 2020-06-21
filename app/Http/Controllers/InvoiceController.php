<?php

namespace App\Http\Controllers;
use App\Payment;
use App\Receipt;
use App\Jobs\ReceiptPdf;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceController extends Controller
{
    
    public function index()
    {
        $data = Payment::create([
            'sponsor_name'=> 'sxb',
            'student_name'=> 'naga dhaaf',
            'student_id'=>' 1',
            'sponsor_id'=> '2',
            'amount' => '2000',
            'status'=> 'pending',

        ]);
        ReceiptPdf::dispatch($data);
        // And return invoice itself to browser or have a different view
        return 'payment done';
    }

    public function show(Receipt $receipt)
    {
      
       $pdflink = $receipt->url;
       return view('welcome', compact('pdflink'));
        
    }
}
