<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // ✅ ถ้าเป็น Admin หรือ Superadmin ให้ผ่านทุกกรณี
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            return $next($request);
        }

        // ✅ ถ้าตรงกับ role ที่กำหนดให้ผ่าน
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        // ❌ ถ้าไม่มีสิทธิ์ ให้แสดง 403
        abort(403, 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
    }
}
