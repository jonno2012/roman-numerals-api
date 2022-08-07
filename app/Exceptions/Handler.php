<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Traits\ResponseTrait;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function render($request, \Throwable $e)
    {
        if($e instanceof  NotFoundHttpException) {
            return $this->responseJson(false, HttpResponse::HTTP_NOT_FOUND, [$e->getMessage()]);
        }

        if($e instanceof  ValidationException) {
            $errors = $e->validator->errors()->getMessages();
            return $this->responseJson(false, HttpResponse::HTTP_UNPROCESSABLE_ENTITY, $errors);
        }

        if($e instanceof  MethodNotAllowedHttpException) {
            return $this->responseJson(false, HttpResponse::HTTP_METHOD_NOT_ALLOWED, [$e->getMessage()]);
        }

        if($e instanceof  \Exception) {
            if(env('APP_ENV') === 'local') {
                $message = [];
                $message['message'] = $e->getMessage();
                $message['file'] = $e->getFile().': ' .$e->getLine();
                $message['trace'] = explode("\n", $e->getTraceAsString());
            } else {
                $message = ['Something went wrong'];
            }
            return $this->responseJson(false, HttpResponse::HTTP_INTERNAL_SERVER_ERROR, $message);
        }
    }
}
