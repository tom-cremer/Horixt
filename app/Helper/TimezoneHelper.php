<?php

namespace App\Helper;

class TimezoneHelper
{
    public static function set()
    {
        if (session()->has('timezone')) {
            date_default_timezone_set(session('timezone', 'UTC'));
        }
    }
}
