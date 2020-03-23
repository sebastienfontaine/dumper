<?php

namespace SebastienFontaine\Dumper\Modules\Factories;

use Exception;
use Spatie\DbDumper\Databases\MongoDb;
use Spatie\DbDumper\Databases\MySql;
use Spatie\DbDumper\Databases\PostgreSql;
use Spatie\DbDumper\Databases\Sqlite;
use Spatie\DbDumper\DbDumper;

class DumperDriverFactory
{
    const AUTHORIZED_DB = [
        'mysql',
        'sqlite',
        'mongodb',
        'pgsql',
    ];

    /**
     * @param string $database
     *
     * @throws \Exception
     *
     * @return DbDumper
     */
    public static function create(string $database): DbDumper
    {
        if (in_array($database, self::AUTHORIZED_DB, true) === false) {
            throw new Exception('Driver not authorized : ' . implode(', ', self::AUTHORIZED_DB));
        }

        switch ($database) {
            case 'mysql':
                return MySql::create();
            case 'sqlite':
                return Sqlite::create();
            case 'mongodb':
                return MongoDb::create();
            case 'pgsql':
                return PostgreSql::create();
        }
    }
}
