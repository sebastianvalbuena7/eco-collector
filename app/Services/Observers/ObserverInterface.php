<?php
namespace App\Services\Observers;

use App\Models\Collection;

interface ObserverInterface
{
    public function update(Collection $collection): void;
}
