<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\PostGetDadosUsers;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //

    public function getDadosUsers(PostGetDadosUsers $request): JsonResponse
    {
        $user = User::where('email', '=', $request->email)
            ->where('password', '=', $request->password)->first();

        if (empty($user)) {
            return response()->json('Usuario não autorizado', 402);
        } else {
            return response()->json($user, 200);
        }
    }
}
