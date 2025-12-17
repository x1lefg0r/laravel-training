<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Jobs\SendNewArticleNotification;
use App\Events\NewArticleEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = request('page', 1);
        $cacheKey = 'articles:page:' . $page; 

        $articles = Cache::remember($cacheKey, 60 * 60, function () { 
            return Article::paginate(10);
        });

        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Article::class);

        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Article::class);
    
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
    
        // Создаём статью
        $article = Article::create($validated);
    
        // Отправляем задачу в очередь
        SendNewArticleNotification::dispatch($article, Auth::user());
    
        // Отправляем Push-уведомление
        event(new NewArticleEvent($article));
        
        Cache::forget('articles:page:1');
    
        return redirect()->route('articles.index')
            ->with('success', 'Статья успешно создана! Уведомления отправлены.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        // Увеличиваем счетчик просмотров (это действие должно быть вне кэша)
        $article->increment('views');

        $cacheKey = 'article:' . $article->id;

        // !!! ДОБАВЛЕНО: Кэшируем данные статьи вместе с комментариями
        $articleWithData = Cache::rememberForever($cacheKey, function () use ($article) {
            // Убедитесь, что модель Article имеет отношение 'comments'
            return $article->load('comments'); 
        });

        // Передаем в представление кэшированный объект
        return view('articles.show', ['article' => $articleWithData]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        Gate::authorize('update', $article);

        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        Gate::authorize('update', $article);

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

        Cache::flush();

        return redirect()->route('articles.show', $article->id)
            ->with('success', 'Статья успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        $article->delete();

        Cache::flush();

        return redirect()->route('articles.index')
            ->with('success', 'Статья успешно удалена!');
    }
}