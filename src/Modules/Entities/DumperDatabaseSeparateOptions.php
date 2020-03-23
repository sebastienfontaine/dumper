<?php

namespace SebastienFontaine\Dumper\Modules\Entities;

class DumperDatabaseSeparateOptions
{
    /** @var array */
    public $tables;

    /** @var string */
    public $suffix;

    /** @var array */
    public $includeTables;

    /** @var array */
    public $excludeTables;

    /** @var bool */
    public $withData;

    /**
     * DumperDatabase constructor.
     *
     * @param array $configurations
     */
    public function __construct(array $configurations)
    {
        $this->suffix        = $configurations['suffix'] ?? '';
        $this->tables        = $configurations['tables'] ?? [];
        $this->includeTables = $configurations['include_tables'] ?? [];
        $this->excludeTables = $configurations['exclude_tables'] ?? [];
        $this->withData      = $configurations['with_data'] ?? true;
    }
}
