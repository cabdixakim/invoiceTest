<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $invoice->name }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <link rel="stylesheet" href="{{ asset('/vendor/invoices/bootstrap.min.css') }}">

        <style type="text/css" media="screen">
            * {
                font-family: "DejaVu Sans";
            }
            html {
                margin: 0;
            }
            
        </style>
    </head>

    <body>
        {{-- Header --}}
       <div >
           <div style="display:flex">
               <div class="">
                   {{$invoice->getSerialNumber()}}
               </div>
               <div>
                  
               </div>
           </div>
       </div>
   
    </body>
</html>
