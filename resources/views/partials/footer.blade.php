<?php
/**
 * Created by PhpStorm.
 * User: Seungmin Lee
 * Date: 2018-03-16
 * Time: 오후 7:24
 */
?>
<div>@lang('interface.language')</div>
<select id="select_language">
    <option id="ko" value="ko">@lang('interface.korean')</option>
    <option id="ja" value="ja">@lang('interface.japanese')</option>
</select>
<script language="JavaScript">
    // 언어 설정
    document.getElementById('select_language').addEventListener('change', function(event) {
        if(event.target.value === '{{ App::getLocale() }}') {
            return;
        }

        location.replace('/language/' + event.target.value);
    });

    // 현재 언어설정 획득하여, 기본 선택 옵션을 해당 언어로 변경
    (function() {
        // 01. 변수 할당
        let httpRequester   = null;
        let url             = '{{ route('home.get_language') }}';

        // ajax 통신 객체 할당
        if(window.XMLHttpRequest) {
            httpRequester = new XMLHttpRequest();
        } else if(window.ActiveXObject) {
            httpRequester = new ActiveXObject("Microsoft.XMLHTTP");
        }

        // 02. 응답 메시지 획득 후 기능 정의
        httpRequester.onreadystatechange = function() {
            if(httpRequester.readyState === 4 && httpRequester.status === 200) {
                document.getElementById(httpRequester.responseText).setAttribute('selected', 'selected');
            } else {
                // 서버와 통신 중...
            }
        }

        // 03. 요청 메시지 정의
        httpRequester.open("GET", url);
        httpRequester.send();
    })();
</script>