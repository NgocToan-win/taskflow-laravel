<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Nếu user đã đăng nhập và có role là admin, redirect sang trang quản trị
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.users.index');
        }

        return $next($request);
    }
}
