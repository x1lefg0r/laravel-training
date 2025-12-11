<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Article $article)
    {
        // Проверяем право на создание комментария
        Gate::authorize('create', Comment::class);

        $validated = $request->validate([
            'author' => 'required|string|max:255',
            'content' => 'required|string|min:3',
        ], [
            'author.required' => 'Укажите ваше имя',
            'content.required' => 'Напишите комментарий',
            'content.min' => 'Комментарий должен содержать минимум 3 символа',
        ]);

        $article->comments()->create($validated);

        return redirect()->route('articles.show', $article->id)
            ->with('success', 'Комментарий успешно добавлен!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        // Проверяем право на редактирование
        Gate::authorize('update', $comment);

        $validated = $request->validate([
            'author' => 'required|string|max:255',
            'content' => 'required|string|min:3',
        ], [
            'author.required' => 'Укажите ваше имя',
            'content.required' => 'Напишите комментарий',
            'content.min' => 'Комментарий должен содержать минимум 3 символа',
        ]);

        $comment->update($validated);

        return redirect()->route('articles.show', $comment->article_id)
            ->with('success', 'Комментарий успешно обновлён!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        // Проверяем право на удаление
        Gate::authorize('delete', $comment);

        $articleId = $comment->article_id;
        $comment->delete();

        return redirect()->route('articles.show', $articleId)
            ->with('success', 'Комментарий успешно удалён!');
    }
}