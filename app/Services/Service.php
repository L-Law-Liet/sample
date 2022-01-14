<?php


namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;

class Service
{
    public static function decrypt($encrypted)
    {
        try {
            return decrypt($encrypted);
        } catch (DecryptException $e) {
            abort(404);
        }
    }
}
