@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-gray-900/50 backdrop-blur-sm border border-gray-800 rounded-2xl p-8">
        <h1 class="text-3xl font-bold mb-6 bg-gradient-to-r from-violet-400 via-purple-400 to-indigo-400 bg-clip-text text-transparent text-center">
            Вход в систему
        </h1>

        <!-- Сообщение об успехе -->
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/50 rounded-lg p-4 mb-6">
                <p class="text-green-400 text-sm">{{ session('success') }}</p>
            </div>
        @endif

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

        <!-- Форма входа -->
        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                    Email
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email') }}"
                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                    placeholder="example@email.com"
                    required
                >
            </div>

            <!-- Пароль -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                    Пароль
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password"
                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                    placeholder="Введите пароль"
                    required
                >
            </div>

            <!-- Запомнить меня -->
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    name="remember" 
                    id="remember"
                    class="w-4 h-4 bg-gray-800 border-gray-700 rounded focus:ring-2 focus:ring-violet-500"
                >
                <label for="remember" class="ml-2 text-sm text-gray-400">
                    Запомнить меня
                </label>
            </div>

            <!-- Кнопка отправки -->
            <button 
                type="submit"
                class="w-full px-6 py-3 bg-gradient-to-r from-violet-600 to-indigo-600 rounded-lg font-semibold hover:from-violet-500 hover:to-indigo-500 transition-all duration-300 hover:scale-105 shadow-lg shadow-violet-500/20"
            >
                Войти
            </button>
        </form>

        <!-- Дополнительная информация -->
        <div class="mt-6 text-center">
            <p class="text-gray-400 text-sm">
                Нет аккаунта? 
                <a href="{{ route('register.create') }}" class="text-violet-400 hover:text-purple-400 transition-colors">Зарегистрироваться</a>
            </p>
        </div>
    </div>
</div>
@endsection