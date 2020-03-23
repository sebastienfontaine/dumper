<?php

namespace SebastienFontaine\Dumper\Events;

use Illuminate\Contracts\Events\Dispatcher;
use SebastienFontaine\Dumper\Jobs\DumperUploadJob;

class DumperEventHandler
{
    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(DumperBackupSucceeded::class, function (DumperBackupSucceeded $event) {
            if ($event->dumperDatabaseInfo->options->uploadInfo->enabled === false) {
                return;
            }

            foreach ($event->files as $file) {
                $job = new DumperUploadJob($event->dumperDatabaseInfo, $file);

                dispatch($job);
            }
        });

        $events->listen(DumperBackupFailed::class, function (DumperBackupFailed $event) {
            logger()->error('Backup failed for database : ' . $event->dumperDatabaseInfo->database);
        });
    }
}
