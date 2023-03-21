<?php

namespace App\Types;

use Illuminate\Support\Collection;

class OS
{
    public const IOS = 0;

    public const ANDROID = 1;

    public const WINDOWS = 2;

    public const BADA = 3;

    public const BLACKBERRY = 4;

    public const MAEMO = 5;

    // Strings

    public const IOS_STRING = 'ios';

    public const ANDROID_STRING = 'android';

    public const WINDOWS_STRING = 'windows';

    public const BADA_STRING = 'bada';

    public const BLACKBERRY_STRING = 'blackberry';

    public const MAEMO_STRING = 'maemo';


    public static function typesCollection(): Collection
    {
        return collect([
            self::IOS => self::IOS_STRING,
            self::ANDROID => self::ANDROID_STRING,
            self::WINDOWS => self::WINDOWS_STRING,
            self::BADA => self::BADA_STRING,
            self::BLACKBERRY => self::BLACKBERRY_STRING,
            self::MAEMO => self::MAEMO_STRING,
        ]);
    }

    public static function toString(?int $type): string|null
    {
        return match ($type) {
            self::IOS => self::IOS_STRING,
            self::ANDROID => self::ANDROID_STRING,
            self::WINDOWS => self::WINDOWS_STRING,
            self::BADA => self::BADA_STRING,
            self::BLACKBERRY => self::BLACKBERRY_STRING,
            self::MAEMO => self::MAEMO_STRING,
            default => null
        };
    }

    public static function toInt(?string $type): int|null
    {
        return match ($type) {
            self::IOS_STRING => self::IOS,
            self::ANDROID_STRING => self::ANDROID,
            self::WINDOWS_STRING => self::WINDOWS,
            self::BADA_STRING => self::BADA,
            self::BLACKBERRY_STRING => self::BLACKBERRY,
            self::MAEMO_STRING => self::MAEMO,
            default => null
        };
    }
}
