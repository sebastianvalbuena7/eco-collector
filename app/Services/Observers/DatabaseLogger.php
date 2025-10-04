<?php
namespace App\Services\Observers;

use App\Models\Collection;
use Illuminate\Support\Facades\DB;

class DatabaseLogger implements ObserverInterface
{
    public function update(Collection $collection): void
    {
        DB::table('collection_logs')->insert([
            'collection_id' => $collection->id,
            'user_id' => $collection->user_id,
            'action' => 'scheduled',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
