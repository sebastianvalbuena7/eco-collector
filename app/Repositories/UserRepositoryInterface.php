<?php
namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data): User;
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getStatistics(int $userId): array;
}