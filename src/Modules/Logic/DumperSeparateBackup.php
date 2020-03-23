<?php

namespace SebastienFontaine\Dumper\Modules\Logic;

use Exception;
use SebastienFontaine\Dumper\Events\DumperBackupStarted;
use SebastienFontaine\Dumper\Modules\Entities\DumperDatabaseSeparateOptions;
use Spatie\DbDumper\DbDumper;

class DumperSeparateBackup extends DumperBackup
{
    /**
     * @throws Exception
     *
     * @return array
     */
    public function backup(): array
    {
        retry($this->dumperDatabaseInfo->options->retry, function () {
            $separateBackupList = $this->prepareSeparateBackupList();

            foreach ($separateBackupList as $separateBackupData) {
                /** @var DbDumper $separateDbDumper */
                $separateDbDumper = $separateBackupData['dumper'];

                /** @var DumperDatabaseSeparateOptions $options */
                $options = $separateBackupData['options'];

                $fileName = $this->destinationPath . '/' . DumperDatabaseLogic::generateBackupFileName($this->dumperDatabaseInfo, $options->suffix);

                event(new DumperBackupStarted($this->dumperDatabaseInfo, $fileName));

                $separateDbDumper->dumpToFile($fileName);

                $this->files[] = $fileName;
            }
        }, 1000);

        return $this->files;
    }

    /**
     * @throws \Spatie\DbDumper\Exceptions\CannotSetParameter
     *
     * @return array
     */
    private function prepareSeparateBackupList(): array
    {
        $separateBackupList = [];

        /** @var DumperDatabaseSeparateOptions $separateBackupOptions */
        foreach ($this->dumperDatabaseInfo->options->separateBackups as $separateBackupOptions) {
            $separateBackupDumper = clone $this->dumper;

            if (count($separateBackupOptions->excludeTables) > 0) {
                $separateBackupDumper->excludeTables($separateBackupOptions->excludeTables);
            }

            if (count($separateBackupOptions->includeTables) > 0) {
                $separateBackupDumper->includeTables($separateBackupOptions->includeTables);
            }

            if ($separateBackupOptions->withData === false) {
                $separateBackupDumper->addExtraOption('--no-data');
            }

            $separateBackupList[] = [
                'dumper'  => $separateBackupDumper,
                'options' => $separateBackupOptions,
            ];
        }

        return $separateBackupList;
    }
}
