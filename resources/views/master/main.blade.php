<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Players</title>

    {{--STYLE SECTION --}}
    <link href="{!! asset('css/app.css')!!}" media="all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @yield('styles')
    {{-- .STYLE SECTION --}}

</head>
<body>

@component('master.header')
@endcomponent

<main>
    <div id="app">
        @yield('content')
    </div>
</main>

@component('master.footer')
@endcomponent


<script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>
@yield('scripts')
</body>
</html>
