<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/admin.pc_index.css')}}">

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

        </div>
        <div class="back">
            <p><a href="{{ url('admin/pc_title') }}">⇦学校一覧</a></p>
        </div>
        <div class="table">
            <table class="pc_school">

                    <thead>
                        <tr>
                            <th></th>
                            <th class="int">端末番号</th>
                            <th class="int">学年</th>
                            <th class="int">クラス</th>
                            <th class="name">名前</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <form action="{{route('admin.check.delete')}}" method="POST" onsubmit="return checkDelete()">
                        @csrf
                        <p class="delete"><button type="submit">選択削除</button></p>
                    <tbody>

                        @foreach($columns as $column)

                        <tr>
                            <td><input class="target" type="checkbox" name="delete[]" value="{{ $column->id }}"></td>
                            <td>{{ $column->id }}</td>
                            <td>{{ $column->grade }}</td>
                            <td>{{ $column->class }}</td>
                            <td>{{ $column->name }}</td>
                            <td class="button"><a href="{{ route('admin.pc.detail', $column->id) }}"class="btn btn-info">詳細</a></td>
                            <td class="button"><a href="{{ route('admin.pc.edit', $column->id) }}" class="btn btn-info">編集</a></td>
                            {{-- <form method="POST" action="{{route('admin.pc.delete',$column->id)}}" onsubmit="return checkDelete()">
                                @csrf
                                <td class="button"><button type="submit" name = "btn btn-primary" onclick=>削除</td>
                            </form> --}}
                        </tr>
                        @endforeach

                    </tbody>
                    </form>
            </table>
            <div class="page">
                <p>{!! $columns->links() !!}</p>
            </div>
        </div>
        <script>
            function checkDelete(){
                if(window.confirm('削除してよろしいですか?')){
                    return true;
                }else{
                    return false;
                }
            }
        </script>
    </x-app-layout>
</body>
</html>
