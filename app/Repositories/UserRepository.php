<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function findById(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function update(int $id, array $data): bool
    {
        $user = $this->findById($id);
        if (!$user) return false;
        return $user->update($data);
    }

    public function delete(int $id): bool
    {
        $user = $this->findById($id);
        if (!$user) return false;
        return (bool) $user->delete();
    }

    public function getStatistics(int $userId): array
    {
        // ejemplo simple: conteos por estado
        $user = $this->findById($userId);
        if (!$user) return [];
        $collections = $user->collections()->get();
        return [
            'total' => $collections->count(),
            'pending' => $collections->where('status','pending')->count(),
            'completed' => $collections->where('status','completed')->count(),
            'in_progress' => $collections->where('status','in_progress')->count(),
        ];
    }
}
