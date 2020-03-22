<?php

namespace SebastienFontaine\Dumper\Modules\Logic;

use SebastienFontaine\Dumper\Events\DumperBackupStarted;
use SebastienFontaine\Dumper\Modules\Entities\DumperDatabaseSeparateOptions;
use Spatie\DbDumper\DbDumper;

class DumperSeparateBackup extends DumperBackup
{
    /**
     * @throws \Spatie\DbDumper\Exceptions\CannotSetParameter
     *
     * @return array
     */
    public function backup(): array
    {
        $excludeTables = collect($this->dumperDatabaseInfo->options->separateBackups)->pluck('tables')->flatten();

        $excludeTables = $excludeTables->merge(collect($this->dumperDatabaseInfo->options->excludeTables))->flatten()->toArray();

        $mainDbDumper = clone $this->dumper;

        $mainDbDumper->excludeTables($excludeTables);

        $separateBackupList = [];

        /** @var DumperDatabaseSeparateOptions $separateBackup */
        foreach ($this->dumperDatabaseInfo->options->separateBackups as $separateBackup) {
            $separateBackupDumper = clone $this->dumper;
            $separateBackupDumper->excludeTables([]);
            $separateBackupDumper->includeTables($separateBackup->tables);

            $separateBackupList[] = [
                'dumper'  => $separateBackupDumper,
                'options' => $separateBackup,
            ];
        }

        retry($this->dumperDatabaseInfo->options->retry, function () use (&$mainDbDumper, &$separateBackupList) {
            $fileName = $this->destinationPath . '/' . DumperDatabaseLogic::generateBackupFileName($this->dumperDatabaseInfo);

            event(new DumperBackupStarted($this->dumperDatabaseInfo, $fileName));

            $mainDbDumper->dumpToFile($fileName);

            $this->files[] = $fileName;

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
}
