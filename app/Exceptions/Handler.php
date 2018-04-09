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
        /* 자작 예외처리 : 메서드 내부에 정의된 조건에 의해 예외가 발생한 경우 => 메시지를 출력하고 뒷 페이지로 돌아감*/
        if ($exception instanceof NotAccessibleException) {
            flash()->error(is_null($exception->getMessage()) ? __('exception.catch_not_accessible_exception') : $exception->getMessage());
            return back();

        /* 데이터 검색에 실패한 경우 => 메시지를 출력하고 뒷 페이지로 돌아감*/
        } else if ($exception instanceof ModelNotFoundException) {
            flash()->error('데이터 검색 실패')->important();
            return back();

        /* URL를 이용한 잘못된 접근 => 에러 페이지 출력 */
        } else if ($exception instanceof ErrorException) {
            return response(view('errors.notice', [
                'title'         => 'Page Not Found',
                'description'   => 'Sorry, the page or resource you are trying to view does not exist. Message: '.$exception->getRawMessage()
            ]), 404);
        }


        return parent::render($request, $exception);
    }
}
