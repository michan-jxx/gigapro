<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/formCheck.css')}}">

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
                {{ __('確認画面') }}
            </h2>
        </x-slot>


        <div class="form">
            <div class="detail">
                <h2>下記の内容をご確認の上送信ボタンを押してください。<br>
                    内容を訂正する場合は戻るを押してください。</h2>
            </div>
            <div class="edit">
                <form method="POST" action="{{ route('user.apply') }}" class="validate">
                @csrf

                    <dl>
                        <dt>端末番号：</dt>
                        <dd>{{$inputs['pc_id']}}<input name="pc_id" value="{{ $inputs['pc_id'] }}" type="hidden"></dd>

                        <dt>申請カテゴリー：</dt>
                        <dd>{{$inputs['category']}}<input name="category" value="{{ $inputs['category'] }}" type="hidden"></dd>

                        <dt>申請内容：</dt>
                        <dd>{!!nl2br(e($inputs['petition']))!!}<input name="petition" value="{{ $inputs['petition'] }}" type="hidden"></dd>
                    </dl>

                    <div class="btn_area">
                        <input type="submit" name="btn-complete" value="送信" class="soushin">
                        <input type="button" name="back" value="戻る" onclick="history.back()" class="modoru">
                    </div>
                </form>
            </div>


        </div>
    </x-app-layout>
</body>
