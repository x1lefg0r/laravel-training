<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Article $article)
    {
        // Валидация
        $validated = $request->validate([
            'author' => 'required|string|max:255',
            'content' => 'required|string|min:3',
        ], [
            'author.required' => 'Укажите ваше имя',
            'content.required' => 'Напишите комментарий',
            'content.min' => 'Комментарий должен содержать минимум 3 символа',
        ]);

        // Создаём комментарий
        $article->comments()->create($validated);

        return redirect()->route('articles.show', $article->id)
            ->with('success', 'Комментарий успешно добавлен!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        // Валидация
        $validated = $request->validate([
            'author' => 'required|string|max:255',
            'content' => 'required|string|min:3',
        ], [
            'author.required' => 'Укажите ваше имя',
            'content.required' => 'Напишите комментарий',
            'content.min' => 'Комментарий должен содержать минимум 3 символа',
        ]);

        // Обновляем комментарий
        $comment->update($validated);

        return redirect()->route('articles.show', $comment->article_id)
            ->with('success', 'Комментарий успешно обновлён!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $articleId = $comment->article_id;
        $comment->delete();

        return redirect()->route('articles.show', $articleId)
            ->with('success', 'Комментарий успешно удалён!');
    }
}