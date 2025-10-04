<?php
namespace App\Services\Observers;

use App\Models\Collection;
use Illuminate\Support\Facades\Mail;

class EmailNotifier implements ObserverInterface
{
    protected string $from = 'noreply@example.com';

    public function update(Collection $collection): void
    {
        $user = $collection->user;
        // ejemplo simple: Mail::raw
        try {
            Mail::raw("Se ha programado una recolección para {$collection->collection_date} {$collection->collection_time}", function($m) use ($user) {
                $m->to($user->email)->from($this->from)->subject('Recolección programada');
            });
        } catch (\Throwable $e) {
            // manejar fallo de envío (log)
        }
    }
}
