<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Invoice;
use App\Models\MeterReadings;
use App\Services\ExportInvoiceAsPdf;
use App\Services\StoreInvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'villager') {
            $villagerId = $user->villager?->id;

            $invoices = Invoice::with('reading.meter.villager')
                ->whereHas('reading.meter', function ($query) use ($villagerId) {
                    $query->where('villager_id', $villagerId);
                })->paginate(10);
        } else {
            $collector_id = $user->id;
            $invoices = Invoice::with('reading.meter.villager')->where('collector_id', $collector_id)->orderByDesc('billing_period')->paginate(10);
        }

        return view('dashboards.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $readings = MeterReadings::with('meter')->doesntHave('invoice')->get();

        return view('dashboards.invoices.create', compact('readings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)

    {

        try {
            $invoice_request = $request->validated();
            StoreInvoiceService::storeInvoice($invoice_request);

            return redirect()->route('invoices')->with('success', "Reading created with success");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoice = Invoice::with(['reading.meter.villager', 'payments'])->where('id', $id)->first();

        return view('dashboards.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function exportPdf(ExportInvoiceAsPdf $exportInvoiceAsPdf, int $id)
    {
        $invoice = Invoice::with(['reading.meter.villager', 'payments'])->findOrFail($id);
        return $exportInvoiceAsPdf->exportInvoicePdf($invoice);
    }
}
