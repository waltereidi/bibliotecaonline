<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
        if( !empty($request->session()->get('url')) ){
            $user->markEmailAsVerified();
        }
        if (!$user->hasVerifiedEmail() ) {
            
            auth()->logout(); // Desloga o usuário
            Session::flash('error', 'Você precisa verificar seu email para continuar.');
            return redirect()->route('login')
                             ->with('error', 'Você precisa verificar seu email para continuar.');
        }

        // O email está verificado, redireciona para onde desejar
        return redirect('/paginainicial');
    }
}
