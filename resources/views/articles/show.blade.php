@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Кнопка назад -->
     @auth
    <div class="mb-8 flex justify-between items-center">
        <a href="{{ route('articles.index') }}" class="inline-flex items-center text-violet-400 hover:text-purple-400 transition-colors group">
            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Вернуться к новостям
        </a>

        <!-- Кнопки управления -->
        <div class="flex space-x-3">
            <a href="{{ route('articles.edit', $article->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition-all duration-300 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Редактировать
            </a>
            <form action="{{ route('articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту статью?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500 transition-all duration-300 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Удалить
                </button>
            </form>
        </div>
    </div>
    @endauth

    <!-- Сообщение об успехе -->
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/50 rounded-lg p-4 mb-6">
            <p class="text-green-400">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Статья -->
    <article class="bg-gray-900/50 backdrop-blur-sm border border-gray-800 rounded-2xl overflow-hidden mb-8">
        <!-- Изображение -->
        <div class="aspect-video bg-gray-800">
            <img 
                src="{{ $article->image }}" 
                alt="{{ $article->title }}"
                class="w-full h-full object-cover"
                onerror="this.src='https://placehold.co/1200x600/1f2937/8b5cf6?text=Article'"
            >
        </div>
        
        <!-- Контент -->
        <div class="p-8">
            <!-- Заголовок -->
            <h1 class="text-4xl font-bold mb-4 bg-gradient-to-r from-violet-400 via-purple-400 to-indigo-400 bg-clip-text text-transparent">
                {{ $article->title }}
            </h1>
            
            <!-- Meta информация -->
            <div class="flex items-center space-x-6 text-gray-400 mb-8 pb-6 border-b border-gray-800">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    {{ $article->author }}
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ $article->published_at->format('d.m.Y') }}
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    {{ $article->views }} просмотров
                </div>
            </div>
            
            <!-- Текст статьи -->
            <div class="prose prose-invert prose-lg max-w-none">
                <p class="text-gray-300 leading-relaxed whitespace-pre-line">
                    {{ $article->content }}
                </p>
            </div>
        </div>
    </article>

    <!-- Секция комментариев -->
    <div class="bg-gray-900/50 backdrop-blur-sm border border-gray-800 rounded-2xl p-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-100 flex items-center">
            <svg class="w-6 h-6 mr-2 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            Комментарии ({{ $article->comments->count() }})
        </h2>

        
    @auth
    <!-- Форма добавления комментария (только для авторизованных) -->
    <div class="mb-8 bg-gray-800/30 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-200 mb-4">Оставить комментарий</h3>
        
        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/50 rounded-lg p-4 mb-4">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-400 text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('comments.store', $article->id) }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label for="author" class="block text-sm font-medium text-gray-300 mb-2">
                    Ваше имя
                </label>
                <input 
                    type="text" 
                    name="author" 
                    id="author" 
                    value="{{ old('author', Auth::user()->name) }}"
                    class="w-full px-4 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                    placeholder="Введите ваше имя"
                >
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-300 mb-2">
                    Комментарий
                </label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="4"
                    class="w-full px-4 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all resize-none"
                    placeholder="Напишите ваш комментарий..."
                >{{ old('content') }}</textarea>
            </div>

            <button 
                type="submit"
                class="px-6 py-2 bg-gradient-to-r from-violet-600 to-indigo-600 rounded-lg font-semibold hover:from-violet-500 hover:to-indigo-500 transition-all duration-300"
            >
                Отправить комментарий
            </button>
        </form>
    </div>
@else
    <!-- Если не авторизован -->
    <div class="mb-8 bg-gray-800/30 rounded-xl p-6 text-center">
        <p class="text-gray-400 mb-4">Чтобы оставить комментарий, необходимо войти в систему</p>
        <a href="{{ route('login') }}" class="inline-block px-6 py-2 bg-gradient-to-r from-violet-600 to-indigo-600 rounded-lg font-semibold hover:from-violet-500 hover:to-indigo-500 transition-all duration-300">
            Войти
        </a>
    </div>
@endauth

        <!-- Список комментариев -->
        <div class="space-y-4">
            @forelse($article->comments()->orderBy('created_at', 'desc')->get() as $comment)
            <div class="bg-gray-800/30 rounded-xl p-6">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h4 class="font-semibold text-violet-400">{{ $comment->author }}</h4>
                        <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                    
                    <!-- Кнопки управления комментарием -->
                    @auth
                    <div class="flex space-x-2">
                        <button 
                            onclick="toggleEditForm({{ $comment->id }})"
                            class="p-1.5 bg-indigo-600/20 text-indigo-400 rounded hover:bg-indigo-600/30 transition-colors"
                            title="Редактировать"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Удалить комментарий?');">
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit"
                                class="p-1.5 bg-red-600/20 text-red-400 rounded hover:bg-red-600/30 transition-colors"
                                title="Удалить"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endauth
                </div>
                
                <!-- Текст комментария -->
                <p class="text-gray-300 leading-relaxed" id="comment-text-{{ $comment->id }}">
                    {{ $comment->content }}
                </p>

                <!-- Форма редактирования (скрыта по умолчанию) -->
                @auth
                <form 
                    id="edit-form-{{ $comment->id }}" 
                    action="{{ route('comments.update', $comment->id) }}" 
                    method="POST" 
                    class="hidden mt-4 space-y-3"
                >

                    @csrf
                    @method('PUT')
                    
                    <div>
                        <input 
                            type="text" 
                            name="author" 
                            value="{{ $comment->author }}"
                            class="w-full px-4 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-gray-100 focus:outline-none focus:ring-2 focus:ring-violet-500"
                            placeholder="Ваше имя"
                        >
                    </div>
                    
                    <div>
                        <textarea 
                            name="content" 
                            rows="3"
                            class="w-full px-4 py-2 bg-gray-800/50 border border-gray-700 rounded-lg text-gray-100 focus:outline-none focus:ring-2 focus:ring-violet-500 resize-none"
                        >{{ $comment->content }}</textarea>
                    </div>
                    
                    <div class="flex space-x-2">
                        <button 
                            type="submit"
                            class="px-4 py-2 bg-violet-600 rounded-lg text-sm font-semibold hover:bg-violet-500 transition-colors"
                        >
                            Сохранить
                        </button>
                        <button 
                            type="button"
                            onclick="toggleEditForm({{ $comment->id }})"
                            class="px-4 py-2 bg-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-600 transition-colors"
                        >
                            Отмена
                        </button>
                    </div>
                </form>
                @endauth
            </div>
            @empty
            <p class="text-gray-500 text-center py-8">Пока нет комментариев. Будьте первым!</p>
            @endforelse
        </div>
    </div>
</div>

<script>
function toggleEditForm(commentId) {
    const text = document.getElementById(`comment-text-${commentId}`);
    const form = document.getElementById(`edit-form-${commentId}`);
    
    if (form.classList.contains('hidden')) {
        text.classList.add('hidden');
        form.classList.remove('hidden');
    } else {
        text.classList.remove('hidden');
        form.classList.add('hidden');
    }
}
</script>
@endsection