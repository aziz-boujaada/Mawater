<?php

namespace   App\Services;

use App\Models\Invoice;
use App\Models\Meter;
use App\Models\Payment;

class   VillagerStatisticsDashboard
{

    public function getReadingsOfVillager($villager_id)
    {
        return Meter::with('meterReadings')
            ->where('villager_id', $villager_id)
            ->get();
    }

    public function getInvoicesOfVillager($villager_id)
    {
        return  Invoice::with(['reading.meter', 'payments'])
            ->whereHas('reading.meter', function ($query) use ($villager_id) {
                $query->where('villager_id', $villager_id);
            })
            ->latest()
            ->get();
    }

    public function getPaymentsOfVillager($villager_id)
    {
        return  Payment::with(['invoice.reading.meter'])
            ->whereHas('invoice.reading.meter', function ($query) use ($villager_id) {
                $query->where('villager_id', $villager_id);
            })
            ->latest()
            ->get();
    }

    public function getTotalReadings($villager_id)
    {
        return Meter::with('meterReadings')
            ->where('villager_id', $villager_id)
            ->count();
    }

    public function getTotalInvoices($villager_id)
    {
        return  Invoice::with(['reading.meter', 'payments'])
            ->whereHas('reading.meter', function ($query) use ($villager_id) {
                $query->where('villager_id', $villager_id);
            })
            ->count();
    }

    public function getTotalPaidInvoices($villager_id)
    {
        return  Invoice::with(['reading.meter', 'payments'])
            ->whereHas('reading.meter', function ($query) use ($villager_id) {
                $query->where('villager_id', $villager_id);
            })->where('status', 'paid')
            ->count();
    }

    public function getTotalAmountOfInvoices($villager_id)
    {
        return  Invoice::with(['reading.meter', 'payments'])
            ->whereHas('reading.meter', function ($query) use ($villager_id) {
                $query->where('villager_id', $villager_id);
            })->sum('total_amount');
    }

    
    public function getPaidAmount($villager_id)
    {
        return  Payment::with(['invoice.reading.meter', 'payments'])
            ->whereHas('invoice.reading.meter', function ($query) use ($villager_id) {
                $query->where('villager_id', $villager_id);
            })->sum('amount_paid');
    }

    public function getUnpaidAmount($villager_id)
    {
        return  Invoice::with(['reading.meter', 'payments'])
            ->whereHas('reading.meter', function ($query) use ($villager_id) {
                $query->where('villager_id', $villager_id);
            })->sum('remaining_amount');
    }
}
