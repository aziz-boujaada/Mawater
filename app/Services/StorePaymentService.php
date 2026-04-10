<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;


class StorePaymentService
{




    public static function calculeDRemainingAmount($payment_data)
    {
        $invoice = Invoice::findOrFail($payment_data['invoice_id']);

        $total_amount = $invoice->total_amount;
        $already_paid = Payment::where('invoice_id', $invoice->id)->sum('amount_paid');
        $amount_paid = $payment_data['amount_paid'];

        $remaining_before_payment = $total_amount - $already_paid;

        if ($amount_paid > $remaining_before_payment) {
            throw new \Exception('The amount paid is greater than remaining amount');
        }

        return $remaining_before_payment - $amount_paid;
    }


    public static function updateInvoiceStatus($remaining_amount, $invoice_id)
    {

        $invoice = Invoice::findOrFail($invoice_id);
        $invoice->remaining_amount = $remaining_amount;

        if ($remaining_amount == 0) {
            $invoice->status = 'paid';
        } else {
            $invoice->status = 'partially_paid';
        }

        return $invoice->save();

    }

    public static function storePayment($payment_data)
    {

        $collector_id = Auth::id();
        $invoice_id = $payment_data['invoice_id'];

        $remaining_amount = self::calculeDRemainingAmount($payment_data);

        $payment = Payment::create([
            'invoice_id'  => $invoice_id,
            'collector_id' => $collector_id,
            'amount_paid' => $payment_data['amount_paid'],
            'payment_date' => now(),

        ]);

        self::updateInvoiceStatus($remaining_amount, $invoice_id);

        return $payment;
    }
}
