<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Carbon\Carbon;

class ValidarTokenApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if( isset($request->Authorization) && 
            User::where('api_token' ,'=',  substr($request->Authorization , 7 ) )->where('validade_token' , '>' , Carbon::now()->toDateString())->first()        ){
            return $next($request);
        }else{
            return response()->json( 'Token não autorizado, gere outro token novamente ', 401 );
        }

        
    }
}
