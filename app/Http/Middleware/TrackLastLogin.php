<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TrackLastLogin
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
        try {
            if (Auth::check()) {
                $user = User::findOrFail(Auth::user()->id);

                if (!$user->last_login || Carbon::parse($user->last_login)->diffInMinutes(now()) > 5) {
                    $user->last_login = now();
                    $user->save();
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to track last login: ' . $e->getMessage());
        }

        return $next($request);
    }
}
