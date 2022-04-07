<?php

namespace App\Http\Controllers\Api;

use App\Core\Http\Controllers\BaseController as Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\ConfirmPhoneRequest;
use App\Http\Requests\Api\ResendSmsConfirmRequest;
use App\Http\Requests\Api\UserCreateRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(AuthService $service)
    {
        parent::__construct($service);
    }

    public function register(UserCreateRequest $request): JsonResponse
    {
        $user = $this->service->register($request);

        return $this->responseWith(compact('user'), 201);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $token = $this->service->login($request);
            return $this->responseWith(compact('token'));
        } catch (\Exception $e) {
            return $this->responseWith(code: $e->getCode(), message: $e->getMessage());
        }
    }

    public function refresh(Request $request)
    {
        try {
            $token = $this->service->refresh($request);
            return $this->responseWith(compact('token'));
        } catch (\Exception $e) {
            return $this->responseWith(code: $e->getCode(), message: $e->getMessage());
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $this->service->logout($request);

            return $this->responseWith(message: __('messages.logout'));
        } catch (\Exception $e) {
            return $this->responseWith(code: $e->getCode(), message: $e->getMessage());
        }
    }

    /**
     * @param ResendSmsConfirmRequest $request
     *
     * @return JsonResponse
     */
    public function resendSms(ResendSmsConfirmRequest $request): JsonResponse
    {
        try {
            $this->service->sendConfirmation($request);

            return $this->responseWith(message: __('sms.confirmation_sent',
                ['attribute' => $request->phone]));
        } catch (\Exception $e) {
            return $this->responseWith(code: $e->getCode(), message: $e->getMessage());
        }
    }

    /**
     * Confirm phone via sms code
     *
     * @param ConfirmPhoneRequest $request
     *
     * @return JsonResponse
     */
    public function confirmPhone(ConfirmPhoneRequest $request): JsonResponse
    {
        try {
            $this->service->confirm($request);

            return $this->responseWith(message: __('messages.phone_confirmed'));
        } catch (\Exception $e) {
            return $this->responseWith(code: $e->getCode(), message: $e->getMessage());
        }
    }

}
