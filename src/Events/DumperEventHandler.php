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
            if (config('dumper.upload_enabled') === false) {
                return;
            }

            foreach ($event->files as $file) {
                $job = new DumperUploadJob($event->dumperDatabaseInfo, $file);

                dispatch($job);
            }
        });
    }
}