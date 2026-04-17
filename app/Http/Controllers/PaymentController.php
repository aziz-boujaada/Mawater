<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use App\Services\StorePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'villager') {
            $villagerId = $user->villager?->id;

            $payments = Payment::with('invoice.reading.meter.villager')
                ->whereHas('invoice.reading.meter', function ($query) use ($villagerId) {
                    $query->where('villager_id', $villagerId);
                })->paginate(10);
        } else {
            $payments = Payment::with('invoice.reading.meter.villager')->paginate(10);
        }
        return view('dashboards.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()

    {
        $user = Auth::user();
        if ($user->role == 'admin') {
            $collectors = User::with('invoices.payments')->whereIn('role', ['collector', 'admin'])->get();
        } elseif ($user->role == 'collector') {
            $collectors = User::with('invoices.payments')->where('id', $user->id)->get();
        }


        return view('dashboards.payments.create', compact('collectors'));
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
     */ public function show($id)
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
