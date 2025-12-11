<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
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

        return null;
    }

    /**
     * Создание комментария (авторизованные пользователи)
     */
    public function create(User $user): bool
    {
        return true; // Любой авторизованный может комментировать
    }

    /**
     * Редактирование комментария (модератор или автор)
     */
    public function update(User $user, Comment $comment): Response
    {
        // Проверяем, является ли пользователь автором комментария
        if ($comment->user_id === $user->id) {
            return Response::allow();
        }

        return Response::deny('Вы можете редактировать только свои комментарии.');
    }

    /**
     * Удаление комментария (модератор или автор)
     */
    public function delete(User $user, Comment $comment): Response
    {
        if ($comment->user_id === $user->id) {
            return Response::allow();
        }

        return Response::deny('Вы можете удалять только свои комментарии.');
    }
}