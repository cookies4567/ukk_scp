<?php

namespace App\Http\Middleware;

use App\Models\Pengguna;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {
        $user = Auth::guard()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user instanceof Pengguna) {
            abort(403, 'Model pengguna tidak valid.');
        }

        $roles = array_map('intval', $roles);

        // Mendukung multi peran (mis. Wali Kelas yang merangkap Guru)
        if (!$user->punyaPeran(...$roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
