<?php
/**
 * Created by PhpStorm.
 * User: Seungmin Lee
 * Date: 2018-04-12
 * Time: 오후 9:52
 */

namespace App\Http\Controllers;

/**
 * Class ResponseObject
 * 클래스 설명: 이기종 간 응답을 위해 사용하는 객체
 * @package App\Http\Controllers
 */
class ResponseObject {
    // status: 실행 결과
    // message: 메시지
    public $status, $message;

    public function __construct($argStatus, $argMessage) {
        $this->status = $argStatus;
        $this->message = $argMessage;
    }
}