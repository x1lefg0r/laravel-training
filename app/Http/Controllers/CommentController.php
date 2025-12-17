<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Показать страницу модерации комментариев (только для модераторов)
     */
    public function moderation()
    {
        // Проверяем, что пользователь - модератор
        if (!Auth::user() || !Auth::user()->isModerator()) {
            abort(403, 'Доступ запрещён. Только модераторы могут просматривать эту страницу.');
        }

        // Получаем все комментарии на модерации
        $comments = Comment::with(['article', 'user'])
            ->pending()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('comments.moderation', compact('comments'));
    }

    /**
     * Одобрить комментарий
     */
    public function approve(Comment $comment)
    {
        // Проверяем, что пользователь - модератор
        if (!Auth::user() || !Auth::user()->isModerator()) {
            abort(403, 'Доступ запрещён.');
        }

        $comment->update(['is_approved' => true]);

        return redirect()->back()
            ->with('success', 'Комментарий одобрен!');
    }

    /**
     * Отклонить (удалить) комментарий
     */
    public function reject(Comment $comment)
    {
        // Проверяем, что пользователь - модератор
        if (!Auth::user() || !Auth::user()->isModerator()) {
            abort(403, 'Доступ запрещён.');
        }

        $comment->delete();

        return redirect()->back()
            ->with('success', 'Комментарий отклонён и удалён.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Article $article)
    {
        Gate::authorize('create', Comment::class);

        $validated = $request->validate([
            'content' => 'required|string|min:3',
        ], [
            'content.required' => 'Напишите комментарий',
            'content.min' => 'Комментарий должен содержать минимум 3 символа',
        ]);

        // Создаём комментарий (по умолчанию is_approved = false)
        $article->comments()->create([
            'user_id' => Auth::id(),
            'author' => Auth::user()->name,
            'content' => $validated['content'],
            'is_approved' => false, // Ожидает модерации
        ]);

        return redirect()->route('articles.show', $article->id)
            ->with('info', 'Ваш комментарий отправлен на модерацию и появится после одобрения.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string|min:3',
        ], [
            'content.required' => 'Напишите комментарий',
            'content.min' => 'Комментарий должен содержать минимум 3 символа',
        ]);

        // После редактирования комментарий снова отправляется на модерацию
        $comment->update([
            'content' => $validated['content'],
            'is_approved' => false, // Снова на модерацию
        ]);

        return redirect()->route('articles.show', $comment->article_id)
            ->with('info', 'Комментарий обновлён и отправлен на модерацию.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $articleId = $comment->article_id;
        $comment->delete();

        return redirect()->route('articles.show', $articleId)
            ->with('success', 'Комментарий успешно удалён!');
    }
}