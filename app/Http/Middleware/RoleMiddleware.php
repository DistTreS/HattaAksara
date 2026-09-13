<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('warning', 'Silakan masuk terlebih dahulu.');
        }

        $user = Auth::user();

        // Admin has universal superuser access to all features & portals
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Check if user has one of the allowed roles
        if (! in_array($user->role, $roles, true)) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        // If user is hatta_muda, verify that account status is approved
        if ($user->role === 'hatta_muda' && $user->status !== 'approved') {
            if ($user->status === 'pending') {
                return redirect()->route('alumni.pending-notice');
            }

            Auth::logout();

            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif atau pendaftaran belum disetujui.');
        }

        return $next($request);
    }
}
