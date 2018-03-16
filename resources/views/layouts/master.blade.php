<?php
/**
 * Created by PhpStorm.
 * User: Seungmin Lee
 * Date: 2018-03-16
 * Time: 오후 3:16
 */
?>
<!doctype html>
<html lang="ko-kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @yield('head')
</head>
<body>
    <header>
        @yield('body.header')
    </header>
    <section>
        @yield('body.section')
    </section>
    <footer>
        @yield('body.footer')
    </footer>
</body>
</html>
