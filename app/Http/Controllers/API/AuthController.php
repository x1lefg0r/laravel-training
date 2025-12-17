<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Регистрация нового пользователя
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|min:2|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Создаём пользователя
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Назначаем роль "читатель"
            $readerRole = Role::where('name', 'reader')->first();
            $user->roles()->attach($readerRole);

            // Создаём токен
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Регистрация прошла успешно',
                'user' => $user,
                'token' => $token,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Вход пользователя
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Неверный email или пароль',
                ], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Вход выполнен успешно',
                'user' => $user->load('roles'),
                'token' => $token,
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Выход пользователя
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Выход выполнен успешно',
        ], 200);
    }

    /**
     * Получить данные текущего пользователя
     */
    public function user(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user()->load('roles'),
        ], 200);
    }
}