<?php

namespace SebastienFontaine\Dumper\Modules\Logic;

use Illuminate\Console\Scheduling\Schedule;
use SebastienFontaine\Dumper\Jobs\DumperBackupJob;
use SebastienFontaine\Dumper\Modules\Entities\DumperDatabaseInfo;
use SebastienFontaine\Dumper\Modules\Entities\DumperMainConfiguration;
use SebastienFontaine\Dumper\Modules\Storage\DumperStorage;

class DumperBackupScheduler
{
    /**
     * @param Schedule $schedule
     */
    public static function schedule(Schedule &$schedule)
    {
        $dumperConfiguration = new DumperMainConfiguration();

        if ($dumperConfiguration->enabled === false) {
            return;
        }

        /** @var DumperDatabaseInfo $database */
        foreach ($dumperConfiguration->databases as $database) {
            $schedule
                ->job(new DumperBackupJob($database, DumperStorage::current()->destinationPath))
                ->cron($database->options->cron);
        }
    }
}
