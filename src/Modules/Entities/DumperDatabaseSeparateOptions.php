<?php

namespace SebastienFontaine\Dumper\Modules\Entities;

class DumperDatabaseSeparateOptions
{
    /** @var array */
    public $tables;

    /** @var string */
    public $suffix;

    /**
     * DumperDatabase constructor.
     *
     * @param array $configurations
     */
    public function __construct(array $configurations)
    {
        $this->suffix = $configurations['suffix'] ?? '';
        $this->tables = $configurations['tables'] ?? [];
    }
}
