<?php
namespace App\Repositories;

use App\Models\Collection;

interface CollectionRepositoryInterface
{
    public function create(array $data): Collection;
    public function findById(int $id): ?Collection;
    public function getUserCollections(int $userId);
    public function getUpcoming(int $userId);
    public function getMonthlyStats(int $userId, int $year): array;
    public function update(int $id, array $data): bool;
}
