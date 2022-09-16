<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
        <title> Admin</title>
        @include('layouts.head')
    </head>

    <body> 
        @yield('content')
    </body>
</html>
