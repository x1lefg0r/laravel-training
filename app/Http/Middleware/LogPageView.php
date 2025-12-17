<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PageView;
use Illuminate\Support\Facades\Auth;

class LogPageView
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Логируем запрос
        PageView::create([
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            // 'user_agent' => $request->userAgent(),
            'user_id' => Auth::id(),
        ]);

        return $next($request);
    }
}