<?php

namespace SebastienFontaine\Dumper\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use SebastienFontaine\Dumper\Modules\Entities\DumperDatabaseInfo;

class DumperBackupSucceeded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var DumperDatabaseInfo
     */
    public $dumperDatabaseInfo;

    /**
     * @var array
     */
    public $files;

    /**
     * DumperBackupSucceeded constructor.
     *
     * @param DumperDatabaseInfo $dumperDatabase
     * @param array              $files
     */
    public function __construct(DumperDatabaseInfo $dumperDatabase, array $files = [])
    {
        $this->dumperDatabaseInfo = $dumperDatabase;
        $this->files              = $files;
    }
}
