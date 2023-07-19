<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof AuthorizationException ) {
            return Response::json(
                [
                    'status' => 'UNAUTHORIZED',
                    'message' => "This action is unauthorized.",
                ],
                400
            );
        }
        if ($e instanceof ModelNotFoundException) {
            $modelName = strtolower(class_basename($e->getModel()));
            return Response::json(
                    [
                        'status' => 'NOT_FOUND',
                        'message' => "Does not exists any {$modelName} with specified identifier.",
                    ],
                    400
                );
        }
        if ($e instanceof \InvalidArgumentException) {
            return Response::json(
                [
                    'status' => 'INVALID_ARGUMENT',
                    'message' => $e->getMessage(),
                ],
                400
            );
        }

        if ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        return parent::render($request, $e);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->errors();
        return Response::json(
            [
                'status' => 'DATA_MISSING',
                'message' => reset($errors)[0]
            ],
            400
        );
    }
}
