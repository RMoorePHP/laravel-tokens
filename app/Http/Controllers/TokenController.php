<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tokens\Token;

class TokenController extends Controller
{
    public function process($token)
    {
        return Token::from($token)->process();
    }
}
