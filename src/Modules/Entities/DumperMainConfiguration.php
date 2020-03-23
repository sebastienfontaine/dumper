<?php

namespace SebastienFontaine\Dumper\Modules\Entities;

use Illuminate\Support\Collection;

class DumperMainConfiguration
{
    /** @var bool */
    public $enabled;

    /** @var string */
    public $destinationPath;

    /** @var array */
    public $environments;

    /** @var Collection */
    public $databases;

    /**
     * Project constructor.
     */
    public function __construct()
    {
        $configurations = config('dumper');

        $this->enabled         = $configurations['enabled'];
        $this->destinationPath = $configurations['destination_path'];
        $this->environments    = $configurations['environments'] ?? ['prod'];

        $this->databases = collect();

        foreach ($configurations['databases'] as $database) {
            $this->databases->push(new DumperDatabaseInfo($database));
        }
    }
}
