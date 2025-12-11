@extends('layouts.app')

@section('title', 'Новости')

@section('content')
<div class="max-w-7xl mx-auto">
<div class="flex justify-between items-center mb-12">
    <div>
        <h1 class="text-5xl font-bold mb-4 bg-gradient-to-r from-violet-400 via-purple-400 to-indigo-400 bg-clip-text text-transparent">
            Новости
        </h1>
        <p class="text-xl text-gray-400">
            Последние статьи и обновления
        </p>
    </div>
    
@can('create', App\Models\Article::class)
    <!-- Кнопка создания (только для модераторов) -->
    <a href="{{ route('articles.create') }}" class="px-6 py-3 bg-gradient-to-r from-violet-600 to-indigo-600 rounded-lg font-semibold hover:from-violet-500 hover:to-indigo-500 transition-all duration-300 hover:scale-105 shadow-lg shadow-violet-500/20">
        + Создать статью
    </a>
@endcan
</div>

    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/50 rounded-lg p-4 mb-6">
            <p class="text-green-400">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        @forelse($articles as $article)
        <div class="group bg-gray-900/50 backdrop-blur-sm border border-gray-800 rounded-xl overflow-hidden hover:border-violet-500/50 transition-all duration-300">
            <a href="{{ route('articles.show', $article->id) }}">
                <div class="aspect-video overflow-hidden bg-gray-800">
                    <img 
                        src="{{ $article->image }}" 
                        alt="{{ $article->title }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                        onerror="this.src='https://placehold.co/600x400/1f2937/8b5cf6?text=Article'"
                    >
                </div>
            </a>
            
            <div class="p-6">
                <a href="{{ route('articles.show', $article->id) }}">
                    <h3 class="text-xl font-semibold text-violet-400 mb-2 group-hover:text-purple-400 transition-colors line-clamp-2">
                        {{ $article->title }}
                    </h3>
                </a>
                
                <p class="text-gray-400 mb-4 line-clamp-3">
                    {{ Str::limit($article->content, 120) }}
                </p>
                
                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $article->author }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ $article->views }}
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="text-xs text-gray-600">
                        {{ $article->published_at->format('d.m.Y') }}
                    </div>
                    
    @auth
    <!-- Кнопки управления (только для авторизованных) -->
    <div class="flex space-x-2">
@can('update', $article)
    <a href="{{ route('articles.edit', $article->id) }}" class="p-2 bg-indigo-600/20 text-indigo-400 rounded hover:bg-indigo-600/30 transition-colors" title="Редактировать">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>
    </a>
@endcan

@can('delete', $article)
    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту статью?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="p-2 bg-red-600/20 text-red-400 rounded hover:bg-red-600/30 transition-colors" title="Удалить">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </button>
    </form>
@endcan
    </div>
@endauth
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-20">
            <div class="text-6xl mb-4">📰</div>
            <h2 class="text-2xl font-semibold text-gray-300 mb-2">Нет статей</h2>
            <p class="text-gray-500 mb-6">Создайте первую статью</p>
            <a href="{{ route('articles.create') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-violet-600 to-indigo-600 rounded-lg font-semibold hover:from-violet-500 hover:to-indigo-500 transition-all duration-300">
                + Создать статью
            </a>
        </div>
        @endforelse
    </div>

    <div class="flex justify-center">
        {{ $articles->links() }}
    </div>
</div>
@endsection