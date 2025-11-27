<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мой сайт')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-gray-100 min-h-screen flex flex-col">
    <header class="bg-gray-900/50 backdrop-blur-xl border-b border-gray-800">
        <nav class="container mx-auto px-6 py-5">
            <div class="flex items-center justify-between">
                <a href="/" class="text-2xl font-bold">
                    <span class="bg-gradient-to-r from-violet-500 via-purple-500 to-indigo-500 bg-clip-text text-transparent">
                        Project
                    </span>
                </a>
                <ul class="flex space-x-8">
                    <li><a href="/" class="text-gray-300 hover:text-violet-400 transition-all duration-300 hover:scale-105 inline-block">Главная</a></li>
                    <li><a href="/about" class="text-gray-300 hover:text-violet-400 transition-all duration-300 hover:scale-105 inline-block">О нас</a></li>
                    <li><a href="/contacts" class="text-gray-300 hover:text-violet-400 transition-all duration-300 hover:scale-105 inline-block">Контакты</a></li>
                    <li><a href="/signin" class="text-gray-300 hover:text-violet-400 transition-all duration-300 hover:scale-105 inline-block">Регистрация</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container flex-1 mx-auto px-6 py-12 min-h-[calc(100vh-200px)]">
        @yield('content')
    </main>

    <footer class="bg-gray-900/50 backdrop-blur-xl border-t border-gray-800">
        <div class="container mx-auto px-6 py-8">
            <p class="text-gray-400 text-center">Балынин Егор Дмитриевич, гр. 241-3210</p>
        </div>
    </footer>
</body>
</html>