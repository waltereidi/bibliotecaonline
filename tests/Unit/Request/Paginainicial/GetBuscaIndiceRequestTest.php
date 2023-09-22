<?php

namespace Tests\Unit\Request\Paginainicial;

use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\TestCase;
use App\Models\User;

class GetBuscaIndiceRequestTest extends TestCase
{
    public $user;
    public function SetUp(): void
    {
        parent::setUp();
        $this->user = User::where('email', '=', 'testCase@email.com')->first();
        Auth::loginUsingId($this->user->id);
    }
}
