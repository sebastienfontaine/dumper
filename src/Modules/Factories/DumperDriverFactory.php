<?php

namespace SebastienFontaine\Dumper\Modules\Factories;

use Illuminate\Support\Str;
use Spatie\DbDumper\DbDumper;

class DumperDriverFactory
{
    /**
     * @param string $database
     *
     * @return DbDumper
     */
    public static function create(string $database): DbDumper
    {
        $class = Str::studly($database);

        $class = 'Spatie\\DbDumper\\Databases\\' . $class;

        return $class::create();
    }
}
