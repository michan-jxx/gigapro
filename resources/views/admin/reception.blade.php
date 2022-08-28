<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/reception.css')}}">

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
                    {{ __('申請受付一覧') }}
                </h2>
            </x-slot>
            <div>
            <div class="reserch">
                <form action="{{ route('admin.recept') }}" method="GET">
                    <select class="school" name="school">
                            <option  value="">学校</option>
                        @foreach($schools as $key)
                            <option value="{{$key->id}}">{{$key->name}}</option>
                        @endforeach
                    </select>
                    </select>
                    {{-- <input type="text" name="grade" value="{{ $grade }}">年<input type="text" name="class" value="{{ $class }}">組 --}}
                    <input class="keyword" type="text" name="keyword" value="{{ $keyword }}" placeholder="端末番号から検索">
                    <input class="serch" type="submit" value="検索">
                </form>
            </div>
            <div class="table">
                <table class="pc_school">
                    <thead>
                        <tr>
                            <th>端末番号</th>
                            <th>学校名</th>
                            <th>申請日</th>
                            <th>申請カテゴリー</th>
                            <th>修理状況</th>
                            <th>返却日</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td>{{ $post->pc_id }}</td>
                            <td>{{ $post->name }}</td>
                            <td>{{ $post->created_at }}</td>
                            <td>{{ $post->category }}</td>
                            <td>{{ $post->condition }}</td>
                            <td>{{ $post->return_day }}</td>
                            <td class="button"><a href="{{ route('admin.repair', $post->id) }}" class="btn btn-info">修理状況入力</a></td>
                            <td class="button">
                                <form method="POST" action="{{route('admin.complete',$post->id)}}" onsubmit="return checkDelete()">
                                @csrf
                                    <button type="submit" class="button" name = "btn btn-primary" onclick=>完了</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <script>
                function checkDelete(){
                    if(window.confirm('完了してよろしいですか？')){
                        return true;
                    }else{
                        return false;
                    }
                }
            </script>
        </x-app-layout>
    </body>
</html>
