<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/pc_title.css')}}">

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
                    {{ __('学校一覧') }}
                </h2>
            </x-slot>
            <div class="head">
                <div class="import">
                    <p><a href="{{ route('admin.pc.store') }}">新規登録</a></p>
                    <p><a href="{{ route('admin.pc.fileStore') }}">ファイル入力</a></p>
                    <form method="post" action="{{route('admin.pc.export')}}">
                        @csrf
                        <input class="export" type="submit" value="ファイル出力">
                    </form>
                </div>
            </div>
            <div class="table">
                <table class="pc_school">
                    <thead>
                        <tr>
                            <th>学校ID</th>
                            <th>学校名</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schools as $school)
                        <tr>
                            <td>{{$school->id}}</td>
                            <td>{{$school->name}}</td>
                            <td><a href="{{ route('admin.pc.index', $school->id) }}">⇨</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-app-layout>
    </body>
</html>
