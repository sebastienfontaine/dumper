<?php

namespace SebastienFontaine\Dumper\Modules\Factories;

use SebastienFontaine\Dumper\Modules\Entities\DumperDatabaseInfo;
use SebastienFontaine\Dumper\Modules\Logic\DumperBackup;
use SebastienFontaine\Dumper\Modules\Logic\DumperNormalBackup;
use SebastienFontaine\Dumper\Modules\Logic\DumperSeparateBackup;

class DumperFactory
{
    /**
     * @param DumperDatabaseInfo $dumperDatabaseInfo
     * @param string             $destinationPath
     *
     * @throws \Spatie\DbDumper\Exceptions\CannotSetParameter
     *
     * @return DumperBackup
     */
    public function create(DumperDatabaseInfo $dumperDatabaseInfo, string $destinationPath): DumperBackup
    {
        if (count($dumperDatabaseInfo->options->separateBackups) > 0) {
            return new DumperSeparateBackup($dumperDatabaseInfo, $destinationPath);
        }

        return new DumperNormalBackup($dumperDatabaseInfo, $destinationPath);
    }
}
