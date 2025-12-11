@extends('layouts.app')

@section('title', 'Доступ запрещён')

@section('content')
<div class="max-w-2xl mx-auto text-center py-20">
    <div class="bg-red-500/10 border border-red-500/50 rounded-2xl p-12">
        <div class="text-6xl mb-6">🚫</div>
        <h1 class="text-4xl font-bold text-red-400 mb-4">
            Доступ запрещён
        </h1>
        <p class="text-xl text-gray-300 mb-8">
            {{ $exception->getMessage() ?: 'У вас нет прав для выполнения этого действия.' }}
        </p>
        <a href="{{ route('articles.index') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-violet-600 to-indigo-600 rounded-lg font-semibold hover:from-violet-500 hover:to-indigo-500 transition-all duration-300">
            Вернуться к новостям
        </a>
    </div>
</div>
@endsection