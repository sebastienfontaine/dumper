<?php

namespace SebastienFontaine\Dumper\Modules\Logic;

use SebastienFontaine\Dumper\Events\DumperBackupStarted;

class DumperNormalBackup extends DumperBackup
{
    /**
     * @return array
     * @throws \Exception
     */
    public function backup(): array
    {
        $fileName = $this->destinationPath . '/' . DumperDatabaseLogic::generateBackupFileName($this->dumperDatabaseInfo);

        retry($this->dumperDatabaseInfo->options->retry, function () use ($fileName) {
            event(new DumperBackupStarted($this->dumperDatabaseInfo, $fileName));

            $this->dumper->dumpToFile($fileName);

            $this->files[] = $fileName;
        }, 1000);

        return $this->files;
    }
}
