<?php
namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class   ExportInvoiceAsPdf{
    public function exportInvoicePdf($invoice){
          $pdf = Pdf::loadView('Pdfs.invoicePdf' , compact('invoice'));
          return $pdf->download('invoice'.  '-' . $invoice->id . '-' . $invoice->reading?->meter?->villager?->user?->name . '.pdf');
    }
}