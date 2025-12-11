<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::orderBy('published_at', 'desc')->paginate(9);
        
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:255',
            'content' => 'required|string|min:20',
            'author' => 'required|string|max:255',
            'published_at' => 'required|date',
            'image' => 'nullable|url',
        ], [
            'title.required' => 'Заголовок обязателен для заполнения',
            'title.min' => 'Заголовок должен содержать минимум 5 символов',
            'content.required' => 'Содержимое обязательно для заполнения',
            'content.min' => 'Содержимое должно содержать минимум 20 символов',
            'author.required' => 'Автор обязателен для заполнения',
            'published_at.required' => 'Дата публикации обязательна',
            'published_at.date' => 'Неверный формат даты',
            'image.url' => 'Изображение должно быть корректным URL',
        ]);

        Article::create($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Статья успешно создана!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->increment('views');
        
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:255',
            'content' => 'required|string|min:20',
            'author' => 'required|string|max:255',
            'published_at' => 'required|date',
            'image' => 'nullable|url',
        ], [
            'title.required' => 'Заголовок обязателен для заполнения',
            'title.min' => 'Заголовок должен содержать минимум 5 символов',
            'content.required' => 'Содержимое обязательно для заполнения',
            'content.min' => 'Содержимое должно содержать минимум 20 символов',
            'author.required' => 'Автор обязателен для заполнения',
            'published_at.required' => 'Дата публикации обязательна',
            'published_at.date' => 'Неверный формат даты',
            'image.url' => 'Изображение должно быть корректным URL',
        ]);

        $article->update($validated);

        return redirect()->route('articles.show', $article->id)
            ->with('success', 'Статья успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Статья успешно удалена!');
    }
}