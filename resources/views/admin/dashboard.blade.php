<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('管理メニュー画面') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p><a href="{{ url('admin/pc_title') }}">生徒PC一覧</a></p>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <p><a href="{{ url('admin/reception') }}">申請受付一覧</a></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
