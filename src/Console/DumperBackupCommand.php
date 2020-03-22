<?php

namespace SebastienFontaine\Dumper\Console;

use Illuminate\Console\Command;
use SebastienFontaine\Dumper\Jobs\DumperBackupJob;
use SebastienFontaine\Dumper\Modules\Entities\DumperDatabaseInfo;
use SebastienFontaine\Dumper\Modules\Entities\DumperMainConfiguration;
use SebastienFontaine\Dumper\Modules\Storage\DumperStorage;

class DumperBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dumper:backup';

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

        /** @var DumperDatabaseInfo $database */
        foreach ($dumperConfiguration->databases as $database) {
            $backupJob = new DumperBackupJob($database, DumperStorage::current()->destinationPath);

            dispatch($backupJob);
        }
    }
}
