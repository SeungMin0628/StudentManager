<?php

namespace App\Http\Middleware;

use Closure;

/**
 * 클래스명:                       CheckLogin
 * @package                        App\Http\Middleware
 * 클래스 설명:                    각 회원별 기능이 접근할 시, 현재 로그인 상태를 점검하는 미들웨어
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 3월 27일
 *
 * 생성자 매개변수 목록
 *  null
 */
class CheckLogin {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if(!session()->has('user')) {
            flash()->warning('죄송합니다. 허가되지 않은 접근입니다.');
            return redirect(route('home.index'));
        }

        return $next($request);
    }
}
