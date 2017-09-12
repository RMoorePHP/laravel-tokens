<?php

namespace App\Tokens;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Queue\SerializesModels;

class Token
{
    use SerializesModels;

    protected function expiresAt()
    {
        return null;
    }

    private function buildData()
    {
        return [
            'expires' => optional($this->expiresAt())->getTimestamp() ?? false,
            'data' => serialize($this),
        ];
    }

    public function __toString()
    {
        return Crypt::encryptString(json_encode($this->buildData()));
    }

    public static function fromToken($token)
    {
        $content = json_decode(Crypt::decryptString($token));

        if ($content->expires) {
            $expires = Carbon::createFromTimestamp($content->expires);
            if ($expires->lt(Carbon::now())) {
                throw new \Exception("Token Expired");
            }
        }

        return (unserialize($content->data));
    }

    public static function handle($token)
    {
        static::fromToken($token)->process($content->data);
    }
}
