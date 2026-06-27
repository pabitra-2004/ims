<?php

namespace App\Http\Controllers\Pdfs;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderInvoiceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order)
    {
        $order = $order->load([
            'customer.addresses',
            'orderDetails.product',
        ]);

        $pdf = Pdf::loadView('pdfs.order-invoice', [
            'order' => $order,
        ])->setPaper('a4');

        return $pdf->stream(
            'invoice-'.$order->code.'.pdf'
        );
    }
}

// public function preview()
// {
//     $pdf = Pdf::loadView(
//         'pdf.invoice',
//         ['order' => $this->order]
//     )->setPaper('a4');

//     return response()->streamDownload(
//         fn () => print ($pdf->stream()),
//         "invoice-{$order->code}.pdf"
//     );
// }

// public function download()
// {
//     $pdf = Pdf::loadView(
//         'pdf.invoice',
//         ['order' => $this->order]
//     );

//     return response()->streamDownload(
//         fn () => print ($pdf->output()),
//         "invoice-{$order->code}.pdf"
//     );
// }
