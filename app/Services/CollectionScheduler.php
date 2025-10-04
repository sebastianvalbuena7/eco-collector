<?php
namespace App\Services;

use App\Models\Collection;
use App\Services\Observers\ObserverInterface;

class CollectionScheduler
{
    /** @var ObserverInterface[] */
    protected array $observers = [];

    public function attach(ObserverInterface $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(ObserverInterface $observer): void
    {
        $this->observers = array_filter($this->observers, fn($o) => $o !== $observer);
    }

    protected function notify(Collection $collection): void
    {
        foreach ($this->observers as $obs) {
            $obs->update($collection);
        }
    }

    /**
     * Crea y notifica observadores.
     */
    public function scheduleCollection(array $data): Collection
    {
        $collection = Collection::create($data);
        $this->notify($collection);
        return $collection;
    }
}
