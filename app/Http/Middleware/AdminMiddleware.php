<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware { // Посредник для контроля доступа к админке сайта
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check () && Auth::user()->is_admin) { // Проверяем авторизован ли пользователь Auth::check И если пользователь авторизован, проверяем является ли он админом Auth::user()->is_admin
            return $next($request); // Если проверка прошла успешно, мы пропускаем пользователя к админ-панели
        }
        abort (404); // Вернет нам код ошибки 404. Это полезно тем, что мы можем скрыть админку для неавторизованных пользователей и взломщиков
    }
}
