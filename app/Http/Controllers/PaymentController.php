<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use App\Services\StorePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()

    {
        $user = Auth::user() ; 
        if($user->role == 'admin'){
            $collectors = User::with('invoices')->whereIn('role' , ['collector' ,'admin'])->get() ; 

        }elseif($user->role == 'collector'){
            $collectors = User::with('invoices')->where('id' , $user->id)->get();
        }
        return view('payments.create' , compact('collectors')) ;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $payment_data = $request->validated();
        StorePaymentService::storePayment($payment_data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
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
