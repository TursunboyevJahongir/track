<?php

namespace App\Contracts;

use App\Core\Contracts\CoreRepositoryContract;
use App\Core\Models\CoreModel;
use App\Models\RefreshToken;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

interface UserRepositoryContract extends CoreRepositoryContract
{
    public function selfExclude(
        Builder $query,
        bool    $selfExclude = false
    );

    public function filterByRole(
        Builder      $query,
        array|string $role = null,
    );

    public function findByPhone(
        int   $phone,
        array $columns = ['*'],
        array $relations = [],
        array $appends = [],
    ): ?CoreModel;

    public function syncRoleToUser(
        User|CoreModel|int $user,
        array|int|string   $roles
    );

    public function generateRefreshToken(User $user): RefreshToken;

    public function findByRefreshToken(Request $request): ?RefreshToken;

    public function findByToken(Request $request): ?RefreshToken;
}
