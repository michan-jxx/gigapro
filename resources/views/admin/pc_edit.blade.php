<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/pc_edit.css')}}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
                {{ __('生徒PC編集画面') }}
            </h2>
        </x-slot>
        <div class="form">
            <form action="{{ route('admin.pc.update') }}" method="POST" onsubmit="return checkEdit()">
            @csrf
                <div class="pc_id">
                    <h1>端末番号{{$pc->id}}</h1>
                    <input type="hidden" name="id" value="{{$pc->id}}">
                </div>
                <div class="edit">
                    <label for="school_id">学校名</label><br>
                    @if($errors -> has('school_id'))
                    <div class ="warning">
                    {{$errors -> first('school_id')}}
                    </div>
                    @endif
                    <select name="school_id">
                        <option value="">選択してください</option>
                    @foreach($users as $key)
                        <option value="{{ $key->id }}">{{ $key->name }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="edit">
                    <label for="grade">学年</label><br>
                    @if($errors -> has('grade'))
                    <div class ="warning">
                    {{$errors -> first('grade')}}
                    </div>
                    @endif
                    <input id="grade" name="grade" type="text"
                    value="{{$pc->grade}}">
                </div>
                <div class="edit">
                    <label for="class">クラス</label><br>
                    @if($errors -> has('class'))
                    <div class ="warning">
                    {{$errors -> first('class')}}
                    </div>
                    @endif
                    <input id="class" name="class" type="text"
                    value="{{$pc->class}}">
                </div>
                <div class="edit">
                    <label for="name">名前</label><br>
                    @if($errors -> has('name'))
                    <div class ="warning">
                    {{$errors -> first('name')}}
                    </div>
                    @endif
                    <input id="name" name="name" type="text"
                    value="{{$pc->name}}">
                </div>

                <div class="button">
                    <p><input type="button" name="back" value="戻る" onclick="history.back()" class="back"></p>
                    <button type="submit" class="btn btn-success">
                        {{ __('更新') }}
                    </button>
                </div>
            </form>
        <script>
            function checkEdit(){
                if(window.confirm('更新してよろしいですか？')){
                    return true;
                }else{
                    return false;
                }
            }
        </script>
    </x-app-layout>
</body>
</html>
