<?php

namespace SebastienFontaine\Dumper\Modules\Storage;

use Illuminate\Support\Facades\Cache;
use SebastienFontaine\Dumper\Modules\Entities\DumperMainConfiguration;

class DumperStorage
{
    private const SINGLE_KEY_STORAGE = 'dumper-storage';

    /**
     * @param DumperMainConfiguration $dumperConfiguration
     *
     * @return DumperMainConfiguration
     */
    public static function put(DumperMainConfiguration $dumperConfiguration): DumperMainConfiguration
    {
        Cache::put(self::SINGLE_KEY_STORAGE, $dumperConfiguration);

        return self::current();
    }

    /**
     * @param bool $forceRefresh
     *
     * @return DumperMainConfiguration|null
     */
    public static function current(bool $forceRefresh = false): ?DumperMainConfiguration
    {
        if (self::exists() === false) {
            $forceRefresh = true;
        }

        if ($forceRefresh === true) {
            Cache::put(self::SINGLE_KEY_STORAGE, new DumperMainConfiguration());
        }

        return Cache::get(self::SINGLE_KEY_STORAGE);
    }

    /**
     * @return bool
     */
    public static function exists(): bool
    {
        return Cache::has(self::SINGLE_KEY_STORAGE);
    }

    /**
     * @return DumperMainConfiguration|null
     */
    public static function refresh(): ?DumperMainConfiguration
    {
        return self::current(true);
    }
}
