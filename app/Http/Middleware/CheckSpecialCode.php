<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSpecialCode
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
        // Перевірка наявності спеціального коду в сесії
        if (!$request->session()->has('special_code')) {
            // Якщо коду немає, перенаправляємо на сторінку введення коду
            return redirect()->route('enter.code');
        }

        // Якщо код є, пропускаємо запит далі
        return $next($request);
    }
}
