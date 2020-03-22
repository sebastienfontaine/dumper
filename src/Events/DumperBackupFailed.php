<?php

namespace SebastienFontaine\Dumper\Events;

use Exception;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use SebastienFontaine\Dumper\Modules\Entities\DumperDatabaseInfo;

class DumperBackupFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var DumperDatabaseInfo
     */
    public $database;

    /**
     * @var Exception
     */
    public $exception;

    /**
     * DumperBackupFailed constructor.
     *
     * @param DumperDatabaseInfo $dumperDatabase
     * @param Exception          $exception
     */
    public function __construct(DumperDatabaseInfo $dumperDatabase, Exception $exception)
    {
        $this->database  = $dumperDatabase;
        $this->exception = $exception;
    }
}
