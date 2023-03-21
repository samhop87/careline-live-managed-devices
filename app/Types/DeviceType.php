<?php

namespace App\Types;

use Illuminate\Support\Collection;

class DeviceType
{
    public const PHONE = 0;

    public const TABLET = 1;

    // Strings

    public const PHONE_STRING = 'phone';

    public const TABLET_STRING = 'tablet';

    public static function typesCollection(): Collection
    {
        return collect([
            self::PHONE => self::PHONE_STRING,
            self::TABLET => self::TABLET_STRING,
        ]);
    }

    public static function toString(?int $type): string|null
    {
        return match ($type) {
            self::PHONE => self::PHONE_STRING,
            self::TABLET => self::TABLET_STRING,
            default => null
        };
    }

    public static function toInt(?string $type): int|null
    {
        return match ($type) {
            self::PHONE_STRING => self::PHONE,
            self::TABLET_STRING => self::TABLET,
            default => null
        };
    }
}

