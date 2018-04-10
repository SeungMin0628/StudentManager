<?php

namespace App\Http\Controllers;

use App\Exceptions\NotAccessibleException;
use App\Exports\UploadScoresFormExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Psy\Exception\ErrorException;
use App\Score;
use App\Professor;

/**
 * 클래스명:                       ExcelController
 * @package                        App\Http\Controllers
 * 클래스 설명:                    엑셀에 대한 기능을 수행하는 컨트롤러 클래스
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 4월 09일
 *
 * 생성자 매개변수 목록
 *  null
 *
 * 멤버 메서드 목록
 *
 */
class ExcelController extends Controller {
    // 01. 멤버 변수

    // 02. 멤버 메서드
    public function exportScoreForm($argFileName, $argFileType, Array $argData) {
        // 엑셀 파일 생성
        $fileType = null;
        switch($argFileType) {
            case 'xlsx':
                $fileType = \Maatwebsite\Excel\Excel::XLSX;
                break;
            case 'xls':
                $fileType = \Maatwebsite\Excel\Excel::XLS;
                break;
            case 'csv':
                $fileType = \Maatwebsite\Excel\Excel::CSV;
                break;
            default:
                throw new ErrorException();
        }
        return Excel::download(new UploadScoresFormExport($argData),
            $argFileName.'.'.$argFileType, $fileType);
    }

    public function importScoreForm($argFilePath) {
        // 01. 전송받은 파일 해석
        $spreadsheet = IOFactory::load($argFilePath);
        $sheetData = $spreadsheet->getActiveSheet()
            ->toArray(null, true, true, true);

        // 02. 유효성 검증 & 데이터 추출
        // 현재 로그인한 교수의 담당과목
        $myLecture  = Professor::findOrFail(session()->get('user')['info']->id)->lecture()->get()[0];

        // 추출 데이터 - 강의 아이디
        $extractData['lecture_id']  = NULL;
        if ($sheetData[1]['B'] == $myLecture->id) {
            $extractData['lecture_id'] = $sheetData[1]['B'];
        } else {
            throw new NotAccessibleException('잘못된 강의 번호');
        }

        // 분류
        $extractData['type'] = NULL;
        if(in_array($sheetData[2]['B'], ConstantEnum::SCORE)) {
            $extractData['type'] = $sheetData[2]['B'];
        }

        // 만점
        $extractData['perfect_score'] = NULL;
        // 자료형이 수 데이터이고, 1 이상 999 이하일 때 참
        if(is_numeric($sheetData[3]['B'])) {
            if(1 <= $sheetData[3]['B'] && 999 >= $sheetData[3]['B']) {
                $extractData['perfect_score'] = $sheetData[3]['B'];
            }
        }

        // 성적 내용
        $extractData['content'] = NULL;
        // 자료형이 문자열이고 2 이상의 길이를 가질 때
        if(is_string($sheetData[4]['B'])) {
            if(strlen($sheetData[4]['B']) >= 2) {
                $extractData['content'] = $sheetData[4]['B'];
            }
        }

        // 추출되지 않은 데이터가 있을 경우 => 예외 발생
        if(in_array(NULL, $extractData)) {
            throw new NotAccessibleException('형식에 맞지 않는 데이터 존재');
        }

        // 학생-점수 리스트
        $extractData['std_list'] = array();
        $signUpList = $myLecture->getIdOfStudents();
        foreach($sheetData as $key => $row) {
            // 키값이 6보다 작으면(학생 리스트 등장 이전) 다음 행 추출
            if($key < 6) {
                continue;
            }

            $stdId = NULL;
            $score = NULL;
            // 행에서 셀을 추출하여 순환
            foreach($row as $deepKey => $cell) {
                // 각 셀에 대해 데이터 무결성 확인
                switch($deepKey) {
                    case 'A':
                        // 학번의 자료형이 수 이고, 강의를 수강하고 있는 학생일 때
                        if(is_numeric($cell)) {
                            if (in_array($cell, $signUpList)) {
                                $stdId = $cell;
                                break;
                            }
                        }
                        throw new NotAccessibleException("등록되지 않은 학생이 존재합니다.");
                    case 'B':
                        continue;
                    case 'C':
                        if(is_numeric($cell)) {
                            if ($cell <= $extractData['perfect_score'] && $cell > 0) {
                                $score = $cell;
                                break;
                            }
                        }
                        throw new NotAccessibleException('형식에 맞지 않게 입력된 점수가 존재합니다.');
                }
            }

            // 데이터 삽입
            $extractData['std_list'][$stdId] = $score;
        }
        // 새로운 점수 유형 생성
        $score = new Score();
        $score->lecture_id      = $extractData['lecture_id'];
        $score->reg_date        = today()->format('Y-m-d');
        $score->type            = $extractData['type'];
        $score->content         = $extractData['content'];
        $score->perfect_score   = $extractData['perfect_score'];

        // 각 학생별로 취득 점수 등록
        if($score->insertScoreList($score, $extractData['std_list'])) {
            flash()->success('성적 등록에 성공하였습니다.');

            return redirect(route('professor.scores.store.main'));
        } else {
            throw new NotAccessibleException('데이터 등록에 실패하였습니다.');
        }
    }
}
