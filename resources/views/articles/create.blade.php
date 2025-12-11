@extends('layouts.app')

@section('title', 'Создать статью')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Кнопка назад -->
    <div class="mb-8">
        <a href="{{ route('articles.index') }}" class="inline-flex items-center text-violet-400 hover:text-purple-400 transition-colors group">
            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Назад к списку
        </a>
    </div>

    <div class="bg-gray-900/50 backdrop-blur-sm border border-gray-800 rounded-2xl p-8">
        <h1 class="text-3xl font-bold mb-6 bg-gradient-to-r from-violet-400 via-purple-400 to-indigo-400 bg-clip-text text-transparent">
            Создать новую статью
        </h1>

        <!-- Ошибки валидации -->
        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/50 rounded-lg p-4 mb-6">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-400 text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Форма -->
        <form action="{{ route('articles.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Заголовок -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-300 mb-2">
                    Заголовок *
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title') }}"
                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                    placeholder="Введите заголовок статьи"
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Автор -->
            <div>
                <label for="author" class="block text-sm font-medium text-gray-300 mb-2">
                    Автор *
                </label>
                <input 
                    type="text" 
                    name="author" 
                    id="author" 
                    value="{{ old('author') }}"
                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                    placeholder="Имя автора"
                >
                @error('author')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Дата публикации -->
            <div>
                <label for="published_at" class="block text-sm font-medium text-gray-300 mb-2">
                    Дата публикации *
                </label>
                <input 
                    type="date" 
                    name="published_at" 
                    id="published_at" 
                    value="{{ old('published_at', date('Y-m-d')) }}"
                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                >
                @error('published_at')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Изображение (URL) -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-300 mb-2">
                    Изображение (URL)
                </label>
                <input 
                    type="url" 
                    name="image" 
                    id="image" 
                    value="{{ old('image') }}"
                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                    placeholder="https://example.com/image.jpg"
                >
                @error('image')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Содержимое -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-300 mb-2">
                    Содержимое *
                </label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="10"
                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all resize-none"
                    placeholder="Введите текст статьи..."
                >{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Кнопки -->
            <div class="flex space-x-4">
                <button 
                    type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-violet-600 to-indigo-600 rounded-lg font-semibold hover:from-violet-500 hover:to-indigo-500 transition-all duration-300 hover:scale-105 shadow-lg shadow-violet-500/20"
                >
                    Создать статью
                </button>
                <a 
                    href="{{ route('articles.index') }}"
                    class="px-6 py-3 bg-gray-700 text-gray-300 rounded-lg font-semibold hover:bg-gray-600 transition-all duration-300"
                >
                    Отмена
                </a>
            </div>
        </form>
    </div>
</div>
@endsection