@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-gray-900/50 backdrop-blur-sm border border-gray-800 rounded-2xl p-8">
        <h1 class="text-3xl font-bold mb-6 bg-gradient-to-r from-violet-400 via-purple-400 to-indigo-400 bg-clip-text text-transparent text-center">
            Регистрация
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

        <!-- Форма регистрации -->
        <form action="{{ route('register') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Имя -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                    Имя *
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name') }}"
                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                    placeholder="Введите ваше имя"
                    required
                >
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                    Email *
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
                    Пароль *
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password"
                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                    placeholder="Минимум 8 символов"
                    required
                >
            </div>

            <!-- Подтверждение пароля -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                    Подтвердите пароль *
                </label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation"
                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all"
                    placeholder="Повторите пароль"
                    required
                >
            </div>

            <!-- Кнопка отправки -->
            <button 
                type="submit"
                class="w-full px-6 py-3 bg-gradient-to-r from-violet-600 to-indigo-600 rounded-lg font-semibold hover:from-violet-500 hover:to-indigo-500 transition-all duration-300 hover:scale-105 shadow-lg shadow-violet-500/20"
            >
                Зарегистрироваться
            </button>
        </form>

        <!-- Дополнительная информация -->
        <div class="mt-6 text-center">
            <p class="text-gray-400 text-sm">
                Уже есть аккаунт? 
                <a href="{{ route('login') }}" class="text-violet-400 hover:text-purple-400 transition-colors">Войти</a>
            </p>
        </div>
    </div>
</div>
@endsection