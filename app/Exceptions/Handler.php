<?php

namespace App\Exceptions;

use App\Core\Traits\Responsable as ResponsableTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;
use TypeError;

class Handler extends ExceptionHandler
{
    use ResponsableTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // Non standard errors handler
        if ($e instanceof ModelNotFoundException) {
            $message = $e->getMessage();
            if (str_contains($message, 'No query results for model')) {
                $message = 'No records found, try another request';
            }
            return $request->expectsJson()
                ? response()->json(['code' => 404,
                    'message' => $message,
                    'data' => []],
                    404)
                : abort(404, $message);
        }
        if ($e instanceof PermissionAlreadyExists) {
            return $request->expectsJson()
                ? response()->json(['code' => 422,
                    'message' => "Permission already exists for this guard",
                    'data' => []],
                    422)
                : abort(422, "Permission already exists for this guard");
        }
        if ($e instanceof AuthorizationException) {
            return $request->expectsJson()
                ? response()->json(['code' => 403,
                    'message' => $e->getMessage(),
                    'data' => []],
                    403)
                : abort(403, $e->getMessage());
        }

        if ($e instanceof UnauthorizedException) {
            return $request->expectsJson()
                ? response()->json(['code' => 422,
                    'message' => 'You dont have permissions to do this action',
                    'data' => []],
                    422)
                : abort(422, "You dont have permissions to do this action");
        }
        if ($e instanceof RoleAlreadyExists) {
            return $request->expectsJson()
                ? response()->json(['code' => 422,
                    'message' => 'This role already exists',
                    'data' => []],
                    422)
                : abort(422, "This role already exists");
        }

        if ($e instanceof TypeError) {
            return $request->expectsJson()
                ? response()->json(['code' => 500,
                    'message' => $e->getMessage(),
                    'data' => []],
                    500)
                : abort(500, $e->getMessage());
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return $request->expectsJson()
                ? response()->json(['code' => 405,
                    'message' => $e->getMessage(),
                    'data' => []],
                    405)
                : abort(405, $e->getMessage());
        }

        if ($e instanceof AuthenticationException) {
            return $request->expectsJson()
                ? response()->json(['code' => 401,
                    'message' => $e->getMessage(),
                    'data' => []],
                    401)
                : abort(401, $e->getMessage());
        }
        // End

        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return Router::toResponse($request, $response);
        } elseif ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        $e = $this->prepareException($this->mapException($e));

        foreach ($this->renderCallbacks as $renderCallback) {
            foreach ($this->firstClosureParameterTypes($renderCallback) as $type) {
                if (is_a($e, $type)) {
                    $response = $renderCallback($e, $request);

                    if (!is_null($response)) {
                        return $response;
                    }
                }
            }
        }

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        }
        if ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

//        if ($e instanceof \Exception) {
//            return response()->json(['code' => 500,
//                'message' => $e->getMessage(),
//                'data' => $e->getTrace()],
//                500);
//        }

        return $this->shouldReturnJson($request, $e)
            ? $this->prepareJsonResponse($request, $e)
            : $this->prepareResponse($request, $e);
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param Request $request
     * @param ValidationException $exception
     *
     * @return JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        return $this->responseWith(['errors' => $exception->errors()], $exception->status, $exception->getMessage());
    }
}
