<?php

namespace App\Common;

use Auth;
use Carbon\Carbon;

class Helpers
{
    // convert a date_time to the local timezone
    public static function localDateTime(string $date_time)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $date_time, 'UTC');
        $date->setTimezone(Auth::user()->timezone);

        return $date;
    }

    // convert a time to the local timezone
    public static function localTime(string $time)
    {
        $date = Carbon::createFromFormat('H:i:s', $time, 'UTC');
        $date->setTimezone(Auth::user()->timezone);

        return $date;
    }
}