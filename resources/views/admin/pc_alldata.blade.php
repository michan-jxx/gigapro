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
                {{ __('全データ一覧') }}
            </h2>
        </x-slot>
        <div class="reserch">
            <form action="{{ route('admin.alldata') }}" method="GET">
                    <select class="school" name="school">
                            <option value="">学校名</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->name }}">{{ $school->name }}</option>
                        @endforeach
                    </select>
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


                    <select class="category" name="category">
                        <option value="">申請カテゴリー</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category}}">{{ $category->category }}</option>
                    @endforeach
                </select>

                <input class="petition" type="text" name="petition" value="{{ $petition }}" placeholder="申請内容から検索">

                <input class="create" type="date" name="create" value="{{ $create }}" >

                <input class="serch" type="submit" value="検索">

            </form>
        </div>

        <div class="table">
            <table class="pc_school">

                    <thead>
                        <tr>
                            <th class="int">端末番号</th>
                            <th class="int">学校ID</th>
                            <th class="name">学校名</th>
                            <th class="int">学年</th>
                            <th class="int">クラス</th>
                            <th class="name">名前</th>
                            <th class="name">申請カテゴリー</th>
                            <th class="name">申請内容</th>
                            <th class="name">申請日</th>
                        </tr>
                    </thead>
                    <form action="{{route('admin.check.delete')}}" method="POST" onsubmit="return checkDelete()">
                        @csrf

                    <tbody>

                        @foreach($items as $item)

                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->school_id }}</td>
                            <td>{{ $item->school_name }}</td>
                            <td>{{ $item->grade }}</td>
                            <td>{{ $item->class }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->petition }}</td>
                            <td>{{ $item->created_at }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                    </form>
            </table>
            <div class="page">
                <p>{!! $items->links() !!}</p>
            </div>
        </div>
    </x-app-layout>
</body>
</html>
