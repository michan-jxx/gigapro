<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/form.css')}}">

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
                {{ __('教育センター申請フォーム') }}
            </h2>
        </x-slot>
        <div class="form">
            <div class="detail">
                <h2>下記の項目をご記入の上確認ボタンを押してください。</h2>
            </div>
            <form method="POST" action="{{ route('user.validation') }}" class="validate">
            @csrf
                <div class="edit">
                    <label for="pc_id">端末番号</label><br>
                    @if ($errors ->has('pc_id'))
                    <div class = "warning">
                        {{$errors -> first('pc_id')}}
                    </div>
                    @endif
                    <input id="pc_id" type="text" name="pc_id" placeholder="1">
                </div>
                <div class="edit">
                    <label for="category">申請カテゴリー</label><br>
                        @if($errors -> has('category'))
                        <div class ="warning">
                        {{$errors -> first('category')}}
                        </div>
                        @endif
                        <select id="category" name="category">
                            <option value="">選択してください</option>
                            <option value="修理">修理</option>
                            <option value="回収・削除">回収・削除</option>
                            <option value="リカバリー">リカバリー</option>
                            <option value="その他">その他</option>
                        </select>
                </div>
                <div class="edit">
                    <label for="petition">申請内容</label><br>
                    @if ($errors ->has('petition'))
                    <div class = "warning">
                        {{$errors -> first('petition')}}
                    </div>
                    @endif
                    <textarea id="petition" name="petition" placeholder="画面破損のため修理対応"></textarea>
                </div>

                <div class="btn_area">
                    <input type="submit" name="btn_confirm" value="確認">
                </div>
            </form>
        </div>
</x-app-layout>
