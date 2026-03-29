<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Invoice;
use App\Models\MeterReadings;
use App\Services\StoreInvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with('reading.meter.villager')->paginate(10);

        return view('dashboards.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $readings = MeterReadings::with('meter')->doesntHave('invoice')->get();
       
        return view('invoices.create', compact('readings'));
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
        $invoice = Invoice::with('reading.meter.villager')->where('id', $id)->first();

        return view('dashboards.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
