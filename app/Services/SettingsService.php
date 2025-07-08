<?php

namespace App\Services;

use App\Models\Setting;

class SettingsService
{
    public static function getSettings()
    {
        return [
            'site' => Setting::getGroup('site'),
            'email' => Setting::getGroup('email'),
            'localization' => Setting::getGroup('localization'),
        ];
    }
}
