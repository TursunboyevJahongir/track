<?php


namespace App\Services;

use App\Contracts\UserRepositoryContract;
use App\Core\Services\CoreService;
use App\Events\PhoneConfirmed;
use App\Events\SmsConfirmCheck;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService extends CoreService
{
    public function __construct(UserRepositoryContract $repository)
    {
        parent::__construct($repository);
    }

    public function register(FormRequest $request)
    {
        $user = DB::transaction(function () use ($request) {
            $user = $this->repository->create($request->validated());
            $this->repository->syncRoleToUser($user, config('project.default_role'));
            return $user;
        });

        return $this->repository->generateRefreshToken($user);
    }

    public function login(FormRequest $request)
    {
        $user = $this->repository->findByPhone($request['phone']);
        if (!$user && !Hash::check($request['password'], $user->password)) {
            throw new \Exception(__('auth.failed'), 401);
        }
        return $this->repository->generateRefreshToken($user);
    }

    public function refresh(Request $request)
    {
        $token = $this->repository->findByRefreshToken($request);
        if ($token) {
            if ($token->refresh_expired_at->greaterThan(now())) {
                $user = $token->user;
                $this->repository->delete($token);
                return $this->repository->generateRefreshToken($user);
            }
            $this->repository->delete($token);
        }

        throw new \Exception('Unauthenticated', 401);
    }

    public function logout(Request $request)
    {
        $token = $this->repository->findByToken($request);
        if (!$token) {
            return throw new \Exception('Unauthenticated', 401);
        }
        auth()->user()->currentAccessToken()?->delete();

        $this->repository->delete($token);
    }

    /**
     * Confirm user phone number
     *
     * @param FormRequest $request
     *
     * @return User
     */
    public function confirm(FormRequest $request): User
    {
        SmsConfirmCheck::dispatch($request->phone, $request->code);
        $user = $this->repository->findByPhone($request->phone);
        PhoneConfirmed::dispatch($user);

        return $user;
    }
}
