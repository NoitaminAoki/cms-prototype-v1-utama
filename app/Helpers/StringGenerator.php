<?php

namespace App\Helpers;
use Illuminate\Support\Str;

class StringGenerator
{
    public static function hashId($length)
    {
        $text = Str::random($length);
        return Str::upper($text);
    }
}