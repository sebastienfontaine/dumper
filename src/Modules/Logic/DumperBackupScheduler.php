<?php

namespace SebastienFontaine\Dumper\Modules\Logic;

use Illuminate\Console\Scheduling\Schedule;
use SebastienFontaine\Dumper\Modules\Entities\DumperDatabaseInfo;
use SebastienFontaine\Dumper\Modules\Entities\DumperMainConfiguration;

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

        /** @var DumperDatabaseInfo $dumperDatabaseInfo */
        foreach ($dumperConfiguration->databases as $dumperDatabaseInfo) {
            $dumperSchedule = $schedule
                ->command('dumper:backup --name=' . $dumperDatabaseInfo->name)
                ->cron($dumperDatabaseInfo->options->cron)
                ->environments($dumperConfiguration->environments);

            if ($dumperDatabaseInfo->options->heartbeatUrl !== null && $dumperDatabaseInfo->options->heartbeatUrl !== '') {
                $dumperSchedule->thenPing($dumperDatabaseInfo->options->heartbeatUrl);
            }
        }
    }
}
