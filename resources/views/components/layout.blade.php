<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-template="st04">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#ffffff">
        <title>IPZ Master</title>
        <link rel="icon" type="image/x-icon" href="{{asset('images/favicon.ico')}}">
        <link rel="stylesheet" href="https://www.uzh.ch/static/magnolia/assets/css/main.css"/>
        <link rel="stylesheet" href="{{asset('css/custom.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    </head>
    <body class="template-st04">
        <x-header/>
        <main>
            {{$slot}}
        </main>
        <x-footer/>
    </body>
</html>

