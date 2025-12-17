<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PageView;
use Illuminate\Support\Facades\Route;


class TrackPageView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Проверяем, что это роут просмотра статьи (например, articles/{article})
        // Используем Route::is() или $request->route() для более точной проверки
        if ($request->routeIs('articles.show')) { // Предполагаем, что ваш роут называется 'articles.show'
            PageView::create([
                'url' => $request->fullUrl(),
                'ip_address' => $request->ip(),
                'user_id' => $request->user() ? $request->user()->id : null,
            ]);
        }
    
        return $next($request);
    }
}
