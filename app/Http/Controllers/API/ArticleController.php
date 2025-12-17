<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Jobs\SendNewArticleNotification;
use App\Events\NewArticleEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ArticleController extends Controller
{
    /**
     * Список всех статей
     */
    public function index()
    {
        $articles = Article::orderBy('published_at', 'desc')->paginate(9);

        return response()->json([
            'success' => true,
            'data' => $articles,
        ], 200);
    }

    /**
     * Создать новую статью
     */
    public function store(Request $request)
    {
        try {
            Gate::authorize('create', Article::class);

            $validated = $request->validate([
                'title' => 'required|string|min:5|max:255',
                'content' => 'required|string|min:20',
                'author' => 'required|string|max:255',
                'published_at' => 'required|date',
                'image' => 'nullable|url',
            ]);

            $article = Article::create($validated);

            // Отправляем уведомления
            SendNewArticleNotification::dispatch($article, Auth::user());
            event(new NewArticleEvent($article));

            return response()->json([
                'success' => true,
                'message' => 'Статья успешно создана',
                'data' => $article,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Нет прав для выполнения этого действия',
            ], 403);
        }
    }

    /**
     * Показать одну статью
     */
    public function show(Article $article)
    {
        $article->increment('views');
        $article->load('comments.user');

        return response()->json([
            'success' => true,
            'data' => $article,
        ], 200);
    }

    /**
     * Обновить статью
     */
    public function update(Request $request, Article $article)
    {
        try {
            Gate::authorize('update', $article);

            $validated = $request->validate([
                'title' => 'required|string|min:5|max:255',
                'content' => 'required|string|min:20',
                'author' => 'required|string|max:255',
                'published_at' => 'required|date',
                'image' => 'nullable|url',
            ]);

            $article->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Статья успешно обновлена',
                'data' => $article,
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Нет прав для выполнения этого действия',
            ], 403);
        }
    }

    /**
     * Удалить статью
     */
    public function destroy(Article $article)
    {
        try {
            Gate::authorize('delete', $article);

            $article->delete();

            return response()->json([
                'success' => true,
                'message' => 'Статья успешно удалена',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Нет прав для выполнения этого действия',
            ], 403);
        }
    }
}