<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-template="st04">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#ffffff">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>IPZ Master</title>
        <link rel="icon" type="image/x-icon" href="{{asset('images/favicon.ico')}}">
        <link rel="stylesheet" href="https://www.uzh.ch/static/magnolia/assets/css/main.css"/>
        <link rel="stylesheet" href="{{ asset('material/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('selectize/selectize.css')}}" />
        <link rel="stylesheet" href="{{ asset('flatpickr/flatpickr.min.css')}}" />
        <script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('alpine/cdn.min.js')}}"></script>
        <script src="{{ asset('selectize/selectize.min.js') }}"></script>
        <script src="{{ asset('flatpickr/flatpickr.min.js') }}"></script>
        <x-head.tinymce-config/>
        <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    </head>
    <body class="template-st04">
        <x-header/>
        <main>
            {{$slot}}
        </main>
        <x-footer/>
    </body>
</html>
