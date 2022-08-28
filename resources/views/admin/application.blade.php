<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/application.css')}}">

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
                {{ __('修理状況入力画面') }}
            </h2>
        </x-slot>
        <div class="form">
            <form action="{{ route('admin.exeUpdate')}}" method="POST" onsubmit="return checkEdit()">
            @csrf
                <div class="pc_id">
                    <h1>端末番号：{{$reps->pc_id}}<input type="hidden" name="pc_id" value="{{$reps->pc_id}}"></h1>
                </div>
                <div class="title">
                    <p>学校名：{{$reps->name}}</p>
                    <p>申請日：{{$reps->created_at}}</p>
                    <p>申請カテゴリー：{{$reps->category}}<input type="hidden" name="category" value="{{$reps->category}}"></p>
                    <p>申請内容：{{$reps->petition}}<input type="hidden" name="petition" value="{{$reps->petition}}"></p>
                    <input type="hidden" name="id" value="{{$reps->id}}">
                </div>
                <div class="edit">
                    <label for="condition">修理状況</label><br>
                    @if($errors -> has('condition'))
                    <div class ="warning">
                    {{$errors -> first('condition')}}
                    </div>
                    @endif
                    <textarea id="condition" name="condition" type="text"
                    value="{{$reps->condition}}">{{$reps->condition}}</textarea>
                </div>
                <div class="edit">
                    <label for="grade">返却予定日</label><br>
                    @if($errors -> has('return_day'))
                    <div class ="warning">
                    {{$errors -> first('return_day')}}
                    </div>
                    @endif
                    <input id="return_day" name="return_day" type="date"
                    value="{{$reps->return_day}}">
                </div>

                <div class="button">
                        <p><input type="button" name="back" value="戻る" onclick="history.back()" class="back"></p>
                    <button type="submit" class="btn btn-success">
                        {{ __('登録') }}
                    </button>
                </div>

            </form>
        </div>
    </x-app-layout>

