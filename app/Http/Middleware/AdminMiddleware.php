<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Проверка аутентификации и наличия роли admin
        // Примечание: Можно адаптировать под структуру вашей базы данных
        if (Auth::check()) {
            // Если в базе есть поле role, можно проверить его
            // if(Auth::user()->role === 'admin') { ... }
            
            // Временно пропускаем всех авторизованных пользователей
            return $next($request);
        }
        
        // Если пользователь не авторизован, редирект на страницу логина
        return redirect()->route('login');
    }
}
