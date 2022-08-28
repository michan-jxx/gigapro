<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/complete.css')}}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('申請完了') }}
            </h2>
        </x-slot>
        <section>
            <div class="detail_a">
                <p>申請完了しました。<br>
                教育センターより折り返しご連絡いたします。</p>
            </div>
            <div class="back">
                <p class="continue"><a href="{{ url('user/form') }}">続けて申請する</a></p>
                <p class="top"><a href="{{ url('dashboard') }}">トップへ戻る</a></p>
            </div>

        </section>
    </x-app-layout>
    </main>
