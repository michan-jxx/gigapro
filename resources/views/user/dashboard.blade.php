<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('メニュー画面') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p><a href="{{url('/user/pc_index')}}">生徒PC一覧</a></p>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <p><a href="{{url('/user/form')}}">教育センター申請フォーム</a></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
