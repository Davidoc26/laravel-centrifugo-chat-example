<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Messenger @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="antialiased bg-white">
<div class="flex justify-center mr-40">
    <div class="flex">
        <x-user-list/>
        @yield('body')
    </div>
</div>


<script src="{{asset('js/app.js')}}"></script>
@stack('scripts')
</body>
</html>
