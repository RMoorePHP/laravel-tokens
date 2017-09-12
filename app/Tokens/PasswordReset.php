<?php

namespace App\Tokens;

use Illuminate\Support\Carbon;

class PasswordReset extends Token
{
    protected $user;

    public function __construct($user = null)
    {
        $this->user = $user;
    }

    public function process()
    {
        return $this->user;
    }

    public function expiresAt()
    {
        return Carbon::now()->addMinutes(2);
    }
}
