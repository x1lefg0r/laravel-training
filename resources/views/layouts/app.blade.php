<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мой сайт')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-gray-100">
    <!-- Header -->
    <header class="bg-gray-900/50 backdrop-blur-xl border-b border-gray-800">
        <nav class="container mx-auto px-6 py-5">
            <div class="flex items-center justify-between">
                <a href="/" class="text-2xl font-bold">
                    <span class="bg-gradient-to-r from-violet-500 via-purple-500 to-indigo-500 bg-clip-text text-transparent">
                        Nexus
                    </span>
                </a>
                <ul class="flex space-x-8 items-center">
                    <li><a href="/" class="text-gray-300 hover:text-violet-400 transition-all duration-300 hover:scale-105 inline-block">Главная</a></li>
                    <li><a href="{{ route('articles.index') }}" class="text-gray-300 hover:text-violet-400 transition-all duration-300 hover:scale-105 inline-block">Новости</a></li>
                    <li><a href="/about" class="text-gray-300 hover:text-violet-400 transition-all duration-300 hover:scale-105 inline-block">О нас</a></li>
                    <li><a href="/contacts" class="text-gray-300 hover:text-violet-400 transition-all duration-300 hover:scale-105 inline-block">Контакты</a></li>
                    
@auth
    <!-- Если пользователь авторизован -->
    <li class="text-gray-400">{{ Auth::user()->name }}</li>
    @if(Auth::user()->isModerator())
        <li><span class="px-2 py-1 bg-violet-600/20 text-violet-400 rounded text-xs font-semibold">Модератор</span></li>
    @endif
    <li>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-gray-300 hover:text-red-400 transition-all duration-300">
                Выйти
            </button>
        </form>
    </li>
@else
    <!-- Если пользователь не авторизован -->
    <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-violet-400 transition-all duration-300 hover:scale-105 inline-block">Вход</a></li>
    <li><a href="{{ route('register.create') }}" class="px-4 py-2 bg-gradient-to-r from-violet-600 to-indigo-600 rounded-lg font-semibold hover:from-violet-500 hover:to-indigo-500 transition-all duration-300">Регистрация</a></li>
@endauth
                </ul>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-12 min-h-[calc(100vh-200px)]">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900/50 backdrop-blur-xl border-t border-gray-800">
        <div class="container mx-auto px-6 py-8">
            <p class="text-gray-400 text-center">Балынин Егор, группа 241-3210</p>
        </div>
    </footer>
</body>
</html>