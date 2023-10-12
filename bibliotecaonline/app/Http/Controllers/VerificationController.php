<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;

class VerificationController extends Controller
{
    use RedirectsUsers;

    // ...

    protected function redirectTo()
    {
        return route('login');
    }

    // ...
}