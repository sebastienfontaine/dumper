<?php

namespace SebastienFontaine\Dumper\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use SebastienFontaine\Dumper\Modules\Entities\DumperDatabaseInfo;

class DumperBackupStarted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var DumperDatabaseInfo
     */
    public $database;

    /**
     * @var string
     */
    public $fileName;

    /**
     * DumperBackupSucceeded constructor.
     *
     * @param DumperDatabaseInfo $dumperDatabase
     * @param string|null        $fileName
     */
    public function __construct(DumperDatabaseInfo $dumperDatabase, string $fileName = null)
    {
        $this->database = $dumperDatabase;
        $this->fileName = $fileName;
    }
}
