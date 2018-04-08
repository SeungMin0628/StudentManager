<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Psy\Exception\ErrorException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception) {
        if ($exception instanceof NotAccessibleException) {
            flash()->error(is_null($exception->getMessage()) ? __('exception.catch_not_accessible_exception') : $exception->getMessage());
            return back();
        } else if ($exception instanceof ErrorException) {
            return response(view('errors.notice', [
                'title'         => 'Page Not Found',
                'description'   => 'Sorry, the page or resource you are trying to view does not exist. Message: '.$exception->getRawMessage()
            ]), 404);
        }


        return parent::render($request, $exception);
    }
}
