<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/pc_fileRegister.css')}}">

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
                {{ __('ファイル入力') }}
            </h2>
        </x-slot>
        <div class ="title">
            <h1>一括新規登録</h1>
        </div>
        <div class="form">
            <div class="complain">
                <p>エクセルファイルで一括で読み込むことができます。</p>
                <p>※注意</p>
                <p>テンプレートをダウンロードし、学校ID・学年・クラスは半角数字で入力してください。</p>
                <p>中学校1年生〜は、7年生〜と設定、予備機は10年10組で設定してください。</p>
            </div>
            <div class="template">
                <a href = "{{ route('user.pc.download') }}">
                    <button class ="btnn">テンプレートをダウンロード</button>
                </a>
            </div>
            <form method="POST" action="{{ route('user.pc.import') }}" enctype="multipart/form-data">
                @csrf
                    @if ($errors->any())
                        <div class="warning">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                <input type="file" id="file" name="file" class="form-control">

                <button type="submit" class="btn">アップロード</button>
            </form>
            <div class="back">
                <p><a href="{{ url('user/pc_index') }}">戻る</a></p>
            </div>
        </div>




    </x-app-layout>
</body>
</html>
