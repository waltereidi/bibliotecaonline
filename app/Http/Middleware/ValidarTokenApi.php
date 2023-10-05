<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ValidarTokenApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->method() === 'GET') {

            $api_token = $request->route()->parameter('authorization');

        } else {
            $api_token = $request->Authorization;
        }

        $user = User::where('api_token', '=',  substr($api_token, 7))->where('validade_token', '>', Carbon::now()->toDateString())->first();
        if (isset($api_token) &&  $user) {
            Auth::loginUsingId($user->id);
            return $next($request);
        } else {
            return response()->json('Token não autorizado, gere outro token novamente ', 401);
        }
    }
}
