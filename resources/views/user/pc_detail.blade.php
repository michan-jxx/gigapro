<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/pc_detail.css')}}">

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
                {{ __('詳細画面') }}
            </h2>
        </x-slot>
        <div class="detail">
            @foreach($pcdets as $pcdet)
            <form>
                <div class="container">
                    <label>端末番号</label>
                        <p>{{ $pcdet->id }}</p>
                </div>
                <div class="container">
                    <label>学校名</label>
                        <p>{{ $pcdet->school }}</p>
                </div>
                <div class="container">
                    <label>学年</label>
                        <p>{{ $pcdet->grade }}</p>
                </div>
                <div class="container">
                    <label>クラス</label>
                        <p>{{ $pcdet->class }}</p>
                </div>
                <div class="container">
                    <label>名前</label>
                        <p>{{ $pcdet->name }}</p>
                </div>
                <div class="container">
                    <label>申請日</label>
                        <p>{{ $pcdet->created_at }}</p>
                </div>
                <div class="container">
                    <label>申請カテゴリー</label>
                        <p>{{ $pcdet->category }}</p>
                </div>
                <div class="container">
                    <label>申請内容</label>
                        <p>{{ $pcdet->petition }}</p>
                </div>
                <div class="container">
                    <label>修理状況</label>
                        <p>{{ $pcdet->condition }}</p>
                </div>
                <div class="container">
                    <label>返却予定日</label>
                        <p>{{ $pcdet->return_day }}</p>
                </div>
            </form>
            @endforeach
            <div class="back">
                <p><a href="{{ url('user/pc_index') }}">戻る</a></p>
            </div>
        </div>


    </x-app-layout>

</body>
</html>
