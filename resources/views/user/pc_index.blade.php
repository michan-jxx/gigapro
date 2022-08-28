<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/pc_index.css')}}">

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
                {{ __('生徒PC一覧') }}
            </h2>
        </x-slot>
        <div class="head">
            <div class="user">
                <h3>{{ $scho->name }}</h3>
                <p>登録台数：{{$county}}</p>
            </div>

            <div class="import">
                <p><a href="{{ route('user.pc.store') }}">新規登録</a></p>
                <p><a href="{{ route('user.pc.fileStore') }}">ファイル入力</a></p>
                <form method="post" action="{{route('user.pc.export')}}">
                    @csrf
                    <input class="export" type="submit" value="ファイル出力">
                </form>
            </div>
        </div>

        <div class="reserch">
            <form action="{{ route('user.index') }}" method="GET">

                    <select class="grade" name="grade">
                            <option value="">学年</option>
                        @foreach($gradese as $grades)
                            <option value="{{ $grades->grade }}">{{ $grades->grade }}</option>
                        @endforeach
                    </select>
                    <select class="class" name="class">
                            <option value="">クラス</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->class}}">{{ $classe->class }}</option>
                        @endforeach
                    </select>

                    <input class="keyword" type="text" name="keyword" value="{{ $keyword }}" placeholder="端末番号、名前から検索">
                    <input class="serch" type="submit" value="検索">

            </form>
        </div>


        <div class="table">
            <table class="pc_school">
                <thead>
                    <tr>
                        <th class="int">端末番号</th>
                        <th class="int">学年</th>
                        <th class="int">クラス</th>
                        <th class="name">名前</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($columns as $column)
                        <tr>
                            <td>{{ $column->id }}</td>
                            <td>{{ $column->grade }}</td>
                            <td>{{ $column->class }}</td>
                            <td>{{ $column->name }}</td>
                            <td class="button"><a href="{{ route('user.pc.detail', $column->id) }}"class="btn btn-info">詳細</a></td>
                            <td class="button"><a href="{{ route('user.pc.edit', $column->id) }}" class="btn btn-info">編集</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="page">
                <p>{!!$columns->links() !!}</p>
            </div>
        </div>

    </x-app-layout>
</body>
</html>
