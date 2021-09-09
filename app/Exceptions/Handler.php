<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
    //
    ///**
    // * Report or log an exception.
    // *
    // * @param  \Exception  $exception
    // * @return void
    // *
    // * @throws \Exception
    // */
    //public function report(Exception $exception)
    //{
    //    parent::report($exception);
    //}


    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return $this->jsonApiError($e, 422, $e->validator->errors()->first());
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->jsonApiError($e, 404, $e->getMessage() ?: 'Not found');
        }

        return parent::render($request, $e);
    }

    protected function jsonApiError(Throwable $e, int $code = 500, $error = null): JsonResponse
    {
        $error = $error ?? $e->getMessage();

        $data = config('app.debug') ? [
            'error' => $error,
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => collect($e->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ] : ['error' => $error];

        return new JsonResponse(
            $data,
            $code,
            [],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
    }
}
