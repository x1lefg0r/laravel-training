<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Показать форму регистрации
     */
    public function createRegister()
    {
        return view('auth.register');
    }

    /**
     * Обработка регистрации
     */
    public function register(Request $request)
    {
        // Валидация
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Поле "Имя" обязательно',
            'name.min' => 'Имя должно содержать минимум 2 символа',
            'email.required' => 'Поле "Email" обязательно',
            'email.email' => 'Введите корректный email',
            'email.unique' => 'Пользователь с таким email уже существует',
            'password.required' => 'Поле "Пароль" обязательно',
            'password.min' => 'Пароль должен содержать минимум 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        // Создаём пользователя
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Редирект на страницу входа
        return redirect()->route('login')
            ->with('success', 'Регистрация прошла успешно! Войдите в систему.');
    }

    /**
     * Показать форму входа
     */
    public function createLogin()
    {
        return view('auth.login');
    }

    /**
     * Обработка входа (авторизация)
     */
    public function login(Request $request)
    {
        // Валидация
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Введите email',
            'email.email' => 'Введите корректный email',
            'password.required' => 'Введите пароль',
        ]);

        // Попытка авторизации
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Создаём токен Sanctum
            $token = $request->user()->createToken('auth-token')->plainTextToken;
            
            // Сохраняем токен в сессии (для веб-приложения)
            session(['sanctum_token' => $token]);

            return redirect()->intended('/')
                ->with('success', 'Добро пожаловать, ' . Auth::user()->name . '!');
        }

        // Если авторизация не удалась
        return back()->withErrors([
            'email' => 'Неверный email или пароль.',
        ])->onlyInput('email');
    }

    /**
     * Выход из системы
     */
    public function logout(Request $request) {
        // Удаляем сессионную аутентификацию
        Auth::logout();
    
        // Инвалидируем сессию
        $request->session()->invalidate();
    
        // Регенерируем CSRF токен
        $request->session()->regenerateToken();
    
        return redirect('/')
             ->with('success', 'Вы успешно вышли из системы.');
    }
}