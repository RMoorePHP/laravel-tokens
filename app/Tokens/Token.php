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
        $lasts = $this->lastsFor();

        if ($lasts === 0) {
            return null;
        }

        return Carbon::now()->addMinutes($lasts);
    }

    protected function lastsFor()
    {
        return 0;
    }

    private function buildData() : array
    {
        return [
            'expires' => optional($this->expiresAt())->getTimestamp() ?? false,
            'data' => serialize($this),
        ];
    }

    final public function __toString()
    {
        return Crypt::encryptString(json_encode($this->buildData()));
    }

    final public static function from($token) : Token
    {
        $content = json_decode(Crypt::decryptString($token));

        if ($content->expires) {
            $expires = Carbon::createFromTimestamp($content->expires);
            if ($expires->lt(Carbon::now())) {
                throw new \Exception("Token Expired");
            }
        }

        return unserialize($content->data);
    }

    public static function handle($token)
    {
        static::fromToken($token)->process($content->data);
    }
}
