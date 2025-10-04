<?php
namespace App\Repositories;

use App\Models\Collection;
use Carbon\Carbon;

class CollectionRepository implements CollectionRepositoryInterface
{
    protected Collection $model;

    public function __construct(Collection $model)
    {
        $this->model = $model;
    }

    public function create(array $data): Collection
    {
        return $this->model->create($data);
    }

    public function findById(int $id): ?Collection
    {
        return $this->model->find($id);
    }

    public function getUserCollections(int $userId)
    {
        return $this->model->where('user_id', $userId)->orderBy('collection_date','desc')->get();
    }

    public function getUpcoming(int $userId)
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('collection_date', '>=', Carbon::today())
            ->orderBy('collection_date')
            ->get();
    }

    public function getMonthlyStats(int $userId, int $year): array
    {
        $rows = $this->model
            ->selectRaw("MONTH(collection_date) as month, COUNT(*) as total")
            ->where('user_id', $userId)
            ->whereYear('collection_date', $year)
            ->groupByRaw('MONTH(collection_date)')
            ->get();

        $result = [];
        foreach ($rows as $r) {
            $result[(int)$r->month] = (int)$r->total;
        }
        return $result;
    }

    public function update(int $id, array $data): bool
    {
        $col = $this->findById($id);
        if (!$col) return false;
        return $col->update($data);
    }
}
