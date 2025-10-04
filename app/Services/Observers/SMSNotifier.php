<?php

namespace App\Services\Observers;

use App\Models\Collection;
use Illuminate\Support\Facades\Log;

class SMSNotifier implements ObserverInterface
{
    public function update(Collection $collection): void
    {
        $phone = $collection->user->phone ?? null;
        if (!$phone) return;
        // integrarlo con proveedor SMS (aquí solo log)
        Log::info("Enviar SMS a {$phone} sobre recolección {$collection->id}");
    }
}
