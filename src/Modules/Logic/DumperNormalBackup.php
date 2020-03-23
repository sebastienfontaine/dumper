<?php

namespace SebastienFontaine\Dumper\Modules\Logic;

use SebastienFontaine\Dumper\Events\DumperBackupStarted;

class DumperNormalBackup extends DumperBackup
{
    /**
     * @throws \Exception
     *
     * @return array
     */
    public function backup(): array
    {
        retry($this->dumperDatabaseInfo->options->retry, function () {
            $fileName = $this->destinationPath . '/' . DumperDatabaseLogic::generateBackupFileName($this->dumperDatabaseInfo);

            event(new DumperBackupStarted($this->dumperDatabaseInfo, $fileName));

            $this->dumper->dumpToFile($fileName);

            $this->files[] = $fileName;
        }, 1000);

        return $this->files;
    }
}
