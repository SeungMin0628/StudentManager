<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */

    protected $except = [
        //
        // 하드웨어 : 출석
        '/student/hardware/come_school',
        '/student/hardware/leave_school',

        // 모바일
        '/login',

        '/student/come_school',
        '/student/leave_school',
        '/tutor/myclass/student_list',
        '/professor/students_list',

        //프론트엔드
        '/tutor/config/store/student/excel/select',
        '/tutor/config/store/student/excel/store',
        '/professor/scores/store/excel/export',
        '/professor/scores/store/excel/import'
    ];

}
