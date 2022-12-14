<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        //
    }

    public function render($request, Throwable $e)
    {

        if ($e instanceof AuthenticationException) {
            return errorResponse(401);

        }
        if ($e instanceof ValidationException) {
            return errorResponse($e->status, $e->validator->errors()->toArray());
        }
        if ($e instanceof RouteNotFoundException) {
            return errorResponse($e->getCode(),[$e->getMessage()],['ادرس درخواستی موجود نیست.']);
        }
        if ($e instanceof NotFoundHttpException) {
            return errorResponse(404);
        }
        if ($e) {
            return errorResponse(500, (array)$e->getMessage(), ['خطای داخلی!!']);
        }
        return parent::render($request, $e);
    }
}
