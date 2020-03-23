<?php

namespace SebastienFontaine\Dumper\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SebastienFontaine\Dumper\Events\DumperBackupFailed;
use SebastienFontaine\Dumper\Events\DumperBackupSucceeded;
use SebastienFontaine\Dumper\Modules\Entities\DumperDatabaseInfo;
use SebastienFontaine\Dumper\Modules\Factories\DumperFactory;

class DumperBackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var DumperDatabaseInfo */
    protected $dumperDatabaseInfo;

    /** @var string */
    protected $destinationPath;

    /**
     * DumperBackupJob constructor.
     *
     * @param DumperDatabaseInfo $dumperDatabase
     * @param string             $destinationPath
     */
    public function __construct(DumperDatabaseInfo $dumperDatabase, string $destinationPath)
    {
        $this->dumperDatabaseInfo = $dumperDatabase;
        $this->destinationPath    = $destinationPath;

        $this->onQueue(config('dumper.backup_queue'));
    }

    public function handle()
    {
        try {
            $files = resolve(DumperFactory::class)->create($this->dumperDatabaseInfo, $this->destinationPath)->backup();
        } catch (Exception $exception) {
            report($exception);

            event(new DumperBackupFailed($this->dumperDatabaseInfo, $exception));

            return;
        }

        event(new DumperBackupSucceeded($this->dumperDatabaseInfo, $files));
    }
}
