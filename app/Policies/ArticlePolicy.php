<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Выполняется перед всеми проверками
     * Если модератор - разрешаем всё
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isModerator()) {
            return true;
        }

        return null; // Продолжаем обычные проверки
    }

    /**
     * Просмотр списка статей (доступно всем)
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Просмотр одной статьи (доступно всем)
     */
    public function view(?User $user, Article $article): bool
    {
        return true;
    }

    /**
     * Создание статьи (только модератор)
     */
    public function create(User $user): Response
    {
        return $user->isModerator()
            ? Response::allow()
            : Response::deny('Только модераторы могут создавать статьи.');
    }

    /**
     * Редактирование статьи (только модератор)
     */
    public function update(User $user, Article $article): Response
    {
        return $user->isModerator()
            ? Response::allow()
            : Response::deny('Только модераторы могут редактировать статьи.');
    }

    /**
     * Удаление статьи (только модератор)
     */
    public function delete(User $user, Article $article): Response
    {
        return $user->isModerator()
            ? Response::allow()
            : Response::deny('Только модераторы могут удалять статьи.');
    }
}