<?php

namespace App\Http\Controllers;

use App\Exports\UploadScoresFormExport;
use Maatwebsite\Excel\Facades\Excel;
use Psy\Exception\ErrorException;

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
    public function export($argFileName, $argFileType, Array $argData) {
        // 엑셀 파일 생성

        /*
        return Excel::create('scores', function($excel) use ($argData) {
            $excel->sheet('scores', function($sheet) use ($argData) {
                $sheet->fromArray($argData);
            });
        })->download($argType);
        */
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
}
