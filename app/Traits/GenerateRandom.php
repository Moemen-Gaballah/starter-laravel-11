<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait GenerateRandom
{

    public function GenerateRandom4DigitNumber() // 4 digit
    {
        if (env('APP_ENV') == 'local')
            return 1234;

        return mt_rand(1000, 9999);
    }

    public function getRandomString($length = 64): string
    {
        $stringSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $stringLength = strlen($stringSpace);
        $randomString = '';
        for ($i = 0; $i < $length; $i ++) {
            $randomString = $randomString . $stringSpace[rand(0, $stringLength - 1)];
        }
        return $randomString;
    }

    public function generateUuid(): string
    {
        return Str::uuid()->toString();
    }

}
