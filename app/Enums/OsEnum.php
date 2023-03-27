<?php

namespace App\Enums;

enum OsEnum: string
{
    case ANDROID = 'android';
    case IOS = 'ios';
    case WINDOWS = 'windows';
    case BADA = 'bada';
    case BLACKBERRY = 'blackberry';
    case MAEMO = 'maemo';
}
