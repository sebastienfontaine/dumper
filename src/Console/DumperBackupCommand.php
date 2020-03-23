<?php

namespace SebastienFontaine\Dumper\Console;

use Exception;
use Illuminate\Console\Command;
use SebastienFontaine\Dumper\Events\DumperBackupFailed;
use SebastienFontaine\Dumper\Events\DumperBackupSucceeded;
use SebastienFontaine\Dumper\Modules\Entities\DumperDatabaseInfo;
use SebastienFontaine\Dumper\Modules\Entities\DumperMainConfiguration;
use SebastienFontaine\Dumper\Modules\Factories\DumperFactory;

class DumperBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dumper:backup {--name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup all databases defined in config files';

    /***
     *
     */
    public function handle()
    {
        $dumperConfiguration = new DumperMainConfiguration();

        if ($dumperConfiguration->enabled === false) {
            return;
        }

        /** @var DumperDatabaseInfo $dumperDatabaseInfo */
        $dumperDatabaseInfo = $dumperConfiguration->databases->filter(function (DumperDatabaseInfo $dumperDatabaseInfo) {
            return $dumperDatabaseInfo->name === $this->option('name');
        })->first();

        try {
            $files = resolve(DumperFactory::class)->create($dumperDatabaseInfo, $dumperConfiguration->destinationPath)->backup();
        } catch (Exception $exception) {
            report($exception);

            event(new DumperBackupFailed($dumperDatabaseInfo, $exception));

            return;
        }

        $this->info('[' . $dumperDatabaseInfo->database . '] ' . $dumperDatabaseInfo->name . ' dumped successfully !');

        event(new DumperBackupSucceeded($dumperDatabaseInfo, $files));
    }
}
