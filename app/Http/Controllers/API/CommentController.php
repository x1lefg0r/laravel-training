<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    /**
     * Список комментариев на модерации
     */
    public function moderation()
    {
        if (!Auth::user() || !Auth::user()->isModerator()) {
            return response()->json([
                'success' => false,
                'message' => 'Доступ запрещён',
            ], 403);
        }

        $comments = Comment::with(['article', 'user'])
            ->pending()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $comments,
        ], 200);
    }

    /**
     * Одобрить комментарий
     */
    public function approve(Comment $comment)
    {
        if (!Auth::user() || !Auth::user()->isModerator()) {
            return response()->json([
                'success' => false,
                'message' => 'Доступ запрещён',
            ], 403);
        }

        $comment->update(['is_approved' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Комментарий одобрен',
            'data' => $comment,
        ], 200);
    }

    /**
     * Отклонить комментарий
     */
    public function reject(Comment $comment)
    {
        if (!Auth::user() || !Auth::user()->isModerator()) {
            return response()->json([
                'success' => false,
                'message' => 'Доступ запрещён',
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Комментарий отклонён и удалён',
        ], 200);
    }

    /**
     * Создать комментарий
     */
    public function store(Request $request, Article $article)
    {
        try {
            Gate::authorize('create', Comment::class);

            $validated = $request->validate([
                'content' => 'required|string|min:3',
            ]);

            $comment = $article->comments()->create([
                'user_id' => Auth::id(),
                'author' => Auth::user()->name,
                'content' => $validated['content'],
                'is_approved' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Комментарий отправлен на модерацию',
                'data' => $comment,
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
     * Обновить комментарий
     */
    public function update(Request $request, Comment $comment)
    {
        try {
            Gate::authorize('update', $comment);

            $validated = $request->validate([
                'content' => 'required|string|min:3',
            ]);

            $comment->update([
                'content' => $validated['content'],
                'is_approved' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Комментарий обновлён и отправлен на модерацию',
                'data' => $comment,
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
     * Удалить комментарий
     */
    public function destroy(Comment $comment)
    {
        try {
            Gate::authorize('delete', $comment);

            $comment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Комментарий успешно удалён',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Нет прав для выполнения этого действия',
            ], 403);
        }
    }
}