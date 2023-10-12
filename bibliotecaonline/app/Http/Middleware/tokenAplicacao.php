<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Aplicativo;

class tokenAplicacao
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->method() === 'GET' || $request->method() === 'DELETE') {

            $api_token = $request->route()->parameter('authorization');

        } else {
            $api_token = $request->Authorization;
        }
        $aplicativo = Aplicativo::where('token_aplicacao', '=',  substr($api_token, 7))
        ->where('nome' ,'=' ,'bibliotecaonline')->first();
        if (isset($api_token) &&  $aplicativo) {
            return $next($request);
        } else {
            return response()->json('Token não autorizado, gere outro token novamente ', 401);
        }
    }
}












