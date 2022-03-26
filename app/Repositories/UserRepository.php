<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryContract;
use App\Core\Models\CoreModel;
use App\Core\Repositories\CoreRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends CoreRepository implements UserRepositoryContract
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function selfExclude(
        Builder $query,
        bool $selfExclude = false
    ) {
        return $query->whenWhere($selfExclude, 'id', '!=', auth()->id());
    }

    public function filterByRole(
        Builder $query,
        array|string $role = null,
    ) {
        return $query->when($role, function ($query) use ($role) {
            $query->role($role);
        });
    }

    public function findByPhone(
        int   $phone,
        array $columns = ['*'],
        array $relations = [],
        array $appends = [],
    ): ?CoreModel
    {
        return $this->availability($this->model)
            ->with($relations)
            ->wherePhone($phone)
            ->first($columns)
            ->append($appends);
    }

    public function syncRoleToUser(
        User|CoreModel|int $user,
        array|int          $roles
    )
    {
        $this->model = is_int($user) ? $this->findById($user) : $user;
        $this->model->syncRoles($roles);
    }
}