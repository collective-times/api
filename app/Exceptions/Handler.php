<?php

namespace App\Exceptions;

use Throwable;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
//        $exception = $this->prepareException($exception);
//
//        if ($exception instanceof AuthenticationException) {
//            return $this->unauthenticated($request, $exception);
//        } elseif ($exception instanceof ValidationException) {
//            return $this->convertValidationExceptionToResponse($exception, $request);
//        } else {
//            $response = $this->convertExceptionToArray($exception);
//            $response['type'] = method_exists($exception, 'getType')
//                ? $exception->getType() :
//                '';
//        }
//
//        return response()->json(
//            $response,
//            $exception->getStatusCode()
//        );
        return parent::render($request, $exception);
    }
}
