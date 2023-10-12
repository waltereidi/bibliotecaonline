<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\PasswordReset;
use App\Notifications\EmailVerify;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{

    use HasApiTokens, HasFactory, Notifiable;
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'created_at',
        'updated_at',
        'validade_token',
        'api_token',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * Validação do email
     *
     */
    protected $middleware = ['auth', 'verified'];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }

    public function gerarNovoToken($id): ?User
    {


        $user = User::find($id);
        $dataAtual = Carbon::now();
        $dataToken = Carbon::parse($user->validade_token);
        if ($dataAtual->diffInDays($dataToken, false) < 2 || empty($user->api_token) || empty($user->validade_token)) {

            $token =  $user->createToken('Token')->plainTextToken;
            User::find($id)->update([
                'updated_at' => now(),
                'api_token' => $token,
                'validade_token' => Carbon::now()->add(7, 'day')->toDateString(),
            ]);
        }
        return User::find($id);
    }
}
