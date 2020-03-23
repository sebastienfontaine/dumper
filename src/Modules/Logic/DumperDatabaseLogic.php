<?php

namespace SebastienFontaine\Dumper\Modules\Logic;

use Carbon\Carbon;
use Illuminate\Support\Str;
use SebastienFontaine\Dumper\Modules\Entities\DumperDatabaseInfo;

abstract class DumperDatabaseLogic
{
    /**
     * @param DumperDatabaseInfo $dumperDatabase
     * @param string             $additionalSuffix
     *
     * @return string
     */
    public static function generateBackupFileName(DumperDatabaseInfo $dumperDatabase, string $additionalSuffix = null): string
    {
        $fileNames   = [];
        $fileNames[] = Carbon::now()->format('Y-m-d-H-i-s.u');
        $fileNames[] = mb_strtolower(Str::kebab($dumperDatabase->database));

        if ($dumperDatabase->options->suffix !== null && $dumperDatabase->options->suffix !== '') {
            $fileNames[] = $dumperDatabase->options->suffix;
        }

        if ($additionalSuffix !== null && $additionalSuffix !== '') {
            $fileNames[] = $additionalSuffix;
        }

        if ($dumperDatabase->options->withCompression === true) {
            $fileNames[] = '.sql.gz';
        } else {
            $fileNames[] = '.sql';
        }

        return Str::replaceLast('-', '', implode('-', $fileNames));
    }
}
