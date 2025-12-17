@extends('layouts.app')

@section('title', 'Модерация комментариев')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <h1 class="text-4xl font-bold mb-4 bg-gradient-to-r from-violet-400 via-purple-400 to-indigo-400 bg-clip-text text-transparent">
            Модерация комментариев
        </h1>
        <p class="text-gray-400">
            Комментарии, ожидающие одобрения: {{ $comments->total() }}
        </p>
    </div>

    <!-- Сообщения -->
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/50 rounded-lg p-4 mb-6">
            <p class="text-green-400">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('info'))
        <div class="bg-blue-500/10 border border-blue-500/50 rounded-lg p-4 mb-6">
            <p class="text-blue-400">{{ session('info') }}</p>
        </div>
    @endif

    <!-- Список комментариев -->
    <div class="space-y-6">
        @forelse($comments as $comment)
        <div class="bg-gray-900/50 backdrop-blur-sm border border-gray-800 rounded-xl p-6 hover:border-violet-500/50 transition-all">
            <!-- Информация о статье -->
            <div class="mb-4 pb-4 border-b border-gray-800">
                <a href="{{ route('articles.show', $comment->article_id) }}" class="text-violet-400 hover:text-purple-400 font-semibold">
                    📰 {{ $comment->article->title }}
                </a>
            </div>

            <!-- Информация об авторе комментария -->
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                        {{ strtoupper(substr($comment->author, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-200">{{ $comment->author }}</h4>
                        <p class="text-sm text-gray-500">
                            {{ $comment->user ? $comment->user->email : 'Email не указан' }}
                        </p>
                        <p class="text-sm text-gray-600">
                            {{ $comment->created_at->format('d.m.Y H:i') }} 
                            ({{ $comment->created_at->diffForHumans() }})
                        </p>
                    </div>
                </div>

                <!-- Статус -->
                <span class="px-3 py-1 bg-yellow-600/20 text-yellow-400 rounded-full text-sm font-semibold">
                    ⏳ На модерации
                </span>
            </div>

            <!-- Текст комментария -->
            <div class="bg-gray-800/30 rounded-lg p-4 mb-4">
                <p class="text-gray-300 leading-relaxed">{{ $comment->content }}</p>
            </div>

            <!-- Кнопки действий -->
            <div class="flex space-x-3">
                <!-- Одобрить -->
                <form action="{{ route('comments.approve', $comment->id) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <button 
                        type="submit"
                        class="w-full px-4 py-3 bg-green-600 hover:bg-green-500 text-white rounded-lg font-semibold transition-all duration-300 flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Одобрить
                    </button>
                </form>

                <!-- Отклонить -->
                <form action="{{ route('comments.reject', $comment->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Вы уверены? Комментарий будет удалён.');">
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit"
                        class="w-full px-4 py-3 bg-red-600 hover:bg-red-500 text-white rounded-lg font-semibold transition-all duration-300 flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Отклонить
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="bg-gray-900/50 backdrop-blur-sm border border-gray-800 rounded-xl p-12 text-center">
            <div class="text-6xl mb-4">✅</div>
            <h2 class="text-2xl font-semibold text-gray-300 mb-2">Нет комментариев на модерации</h2>
            <p class="text-gray-500">Все комментарии проверены!</p>
        </div>
        @endforelse
    </div>

    <!-- Пагинация -->
    @if($comments->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $comments->links() }}
    </div>
    @endif
</div>
@endsection