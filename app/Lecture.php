<?php

namespace App;

use App\Http\DbInfoEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * 클래스명:                       Lecture
 * 클래스 설명:                    강의 테이블과 연결하는 모델
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 19일
 */
class Lecture extends Model {
    // 01. 멤버 변수 설정
    public $timestamps  = false;

    // 02. 생성자 정의
    // 03. 멤버 메서드 정의
    /**
     * 함수명:                         professor
     * 함수 설명:                      강의 테이블과 교수 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function professor() {
        return $this->belongsTo('App\Professor', 'professor', 'id');
    }

    /**
     * 함수명:                         subject
     * 함수 설명:                      교과목 테이블과 강의 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject() {
        return $this->belongsTo('App\Subject', 'subject_id', 'id');
    }

    /**
     * 함수명:                         signUpLists
     * 함수 설명:                      강의 테이블과 수강학생 목록 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function signUpLists() {
        return $this->hasMany('App\SignUpList', 'lecture_id', 'id');
    }

    /**
     * 함수명:                         checkInLectures
     * 함수 설명:                      강의 테이블과 강의중 출석 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checkInLectures() {
        return $this->hasMany('App\CheckInLecture', 'lecture_id', 'id');
    }

    /**
     * 함수명:                         scores
     * 함수 설명:                      강의 테이블과 점수 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scores() {
        return $this->hasMany('App\Score', 'lecture_id', 'id');
    }

    /**
     * 함수명:                         timetables
     * 함수 설명:                      강의 테이블과 시간표 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timetables() {
        return $this->hasMany('App\TimeTable', 'lecture_id', 'id');
    }

    /**
     * 함수명:                         getSignUpStudentsList
     * 함수 설명:                      해당 강의를 수강하는 학생의 학번과 이름 반환
     * 만든날:                         2018년 4월 09일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSignUpStudentsList() {
        return $this->signUpLists()
            ->join(DbInfoEnum::STUDENTS['t_name'],
                DbInfoEnum::STUDENTS['t_name'].'.'.DbInfoEnum::STUDENTS['id'],
                DbInfoEnum::SIGN_UP_LISTS['t_name'].'.'.DbInfoEnum::SIGN_UP_LISTS['s_id']
            )->select([
                DbInfoEnum::STUDENTS['t_name'].'.'.DbInfoEnum::STUDENTS['id'],
                DbInfoEnum::STUDENTS['t_name'].'.'.DbInfoEnum::STUDENTS['name']
            ])->get();
    }

    public function getIdOfStudents() {
        $signUpList = $this->signUpLists()
            ->select(DbInfoEnum::SIGN_UP_LISTS['s_id'])
            ->get()->all();

        $data = array();
        foreach($signUpList as $value) {
            array_push($data, $value->{DbInfoEnum::SIGN_UP_LISTS['s_id']});
        }

        return $data;
    }
}
