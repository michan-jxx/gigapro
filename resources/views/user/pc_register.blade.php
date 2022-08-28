<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/pc_register.css')}}">
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
                {{ __('新規登録') }}
            </h2>
        </x-slot>

        <div class="form">
            <form action="{{ route('user.pc.exeStore') }}" method="POST" onsubmit="return checkCreate()">
            @csrf
                <div class="edit">
                    <label for="school_id">学校名</label><br>
                    @if($errors -> has('school_id'))
                    <div class ="warning">
                    {{$errors -> first('school_id')}}
                    </div>
                    @endif
                    {{-- <input id="school_id" name="school_id" type="text" placeholder="1"> --}}
                    <select class="school_id" name="school_id">
                            <option value="">選択してください</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id}}">{{ $category->name }}</option>
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
                    <input id="grade" name="grade" type="text" placeholder="1">
                </div>
                <div class="edit">
                    <label for="class">クラス</label><br>
                    @if($errors -> has('class'))
                    <div class ="warning">
                    {{$errors -> first('class')}}
                    </div>
                    @endif
                    <input id="class" name="class" type="text" placeholder="1">
                </div>
                <div class="edit">
                    <label for="name">名前</label><br>
                    @if($errors -> has('name'))
                    <div class ="warning">
                    {{$errors -> first('name')}}
                    </div>
                    @endif
                    <input id="name" name="name" type="text" placeholder="大阪　太郎">
                </div>

                <div class="button">
                    <p><a href="{{ route('user.index') }}" class="secondary" role="button">
                        <i class="fa fa-reply mr-1" aria-hidden="true"></i>{{ __('戻る') }}
                    </a></p>
                    <button type="submit" class="btn">
                        {{ __('登録') }}
                    </button>
                </div>
            </form>
        </div>
            <script>
                function checkCreate(){
                    if(window.confirm('登録してよろしいですか？')){
                        return true;
                    }else{
                        return false;
                    }
                }
                </script>
    </x-app-layout>
</body>


