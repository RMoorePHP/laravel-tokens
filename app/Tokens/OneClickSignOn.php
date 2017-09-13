<?php

namespace App\Tokens;

class OneClickSignOn extends Token
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function process()
    {
        auth()->login($this->user);
        return redirect('home');
    }
}
