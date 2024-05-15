<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            $error = 'Route not found';
            if ($e instanceof ModelNotFoundException) {
                $modelName = class_basename($e->getModel());
                $error = "$modelName not found";
            }
            return errorResponse($error, 404);
        }
        elseif ($e instanceof ValidationException) {
            return errorResponse($e->validator->errors()->first(), Response::HTTP_UNPROCESSABLE_ENTITY, $e->validator->errors());
        }

        elseif ($e instanceof ClientErrorException) {
            return errorResponse($e->getMessage(),$e->getCode());
        }

        elseif ($e instanceof ThrottleRequestsException) {
            return errorResponse('Max attempts exceeded.Retry later.',$e->getCode());
        }

        Log::error($e->getMessage());

        return  errorResponse($e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
