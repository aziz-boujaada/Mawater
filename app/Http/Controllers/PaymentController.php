<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use App\Services\ListingQueryService;
use App\Services\StorePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Payment::with('invoice.reading.meter.villager.user', 'collector');

        if ($user->role == 'villager') {
            $villagerId = $user->villager?->id;

            $query->whereHas('invoice.reading.meter', function ($listingQuery) use ($villagerId) {
                $listingQuery->where('villager_id', $villagerId);
            });
        }

        ListingQueryService::apply($query, $request, [
            'search' => ['amount_paid', 'payment_date'],
            'relations' => [
                'invoice' => ['invoice_reference', 'billing_period'],
                'invoice.reading.meter' => ['meter_reference'],
                'invoice.reading.meter.villager.user' => ['name', 'email', 'phone'],
                'collector' => ['name', 'email', 'phone'],
            ],
            'date_field' => 'payment_date',
            'amount_field' => 'amount_paid',
        ]);

        $payments = $query->orderByDesc('payment_date')->paginate(10)->withQueryString();

        return view('dashboards.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = Auth::user();

        $query = Invoice::with(['reading.meter.villager.user', 'payments'])
            ->whereIn('status', ['unpaid', 'partially_paid']);

        if ($user->role === 'collector') {
            $query->where('collector_id', $user->id);
        }

        /** @var \Illuminate\Database\Eloquent\Builder $query */
        ListingQueryService::apply($query, $request, [
            'search' => ['invoice_reference', 'billing_period'],
            'relations' => [
                'reading.meter.villager.user' => ['name', 'email', 'phone'],
                'reading.meter' => ['meter_reference'],
                'collector' => ['name', 'email', 'phone'],
            ],
            'exact' => [
                'status' => 'status',
            ],
            'date_field' => 'billing_period',
            'amount_field' => 'remaining_amount',
        ]);

        $pendingInvoices = $query->orderByDesc('billing_period')->get();

        $villagerGroups = $pendingInvoices
            ->groupBy(function (Invoice $invoice) {
                return $invoice->reading?->meter?->villager?->id ?? $invoice->reading_id;
            })
            ->map(function ($invoices) {
                $firstInvoice = $invoices->first();

                return [
                    'name' => $firstInvoice?->reading?->meter?->villager?->user?->name ?? __('Unassigned'),
                    'villager' => $firstInvoice?->reading?->meter?->villager,
                    'invoices' => $invoices,
                ];
            })
            ->values();

        return view('dashboards.payments.create', compact('villagerGroups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        try {
            $payment_data = $request->validated();
            StorePaymentService::storePayment($payment_data);

            return redirect()->route('payments.create')->with('success', $payment_data['amount_paid'] . ' ' . 'DH' . ' ' . 'is Paid');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $payment = Payment::with(['invoice', 'collector'])->findOrFail($id);

        return view('dashboards.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
