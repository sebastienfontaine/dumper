<?php

namespace SebastienFontaine\Dumper\Modules\Logic;

use Exception;
use Illuminate\Support\Facades\File;
use SebastienFontaine\Dumper\Modules\Entities\DumperDatabaseInfo;
use SebastienFontaine\Dumper\Modules\Factories\DumperDriverFactory;
use Spatie\DbDumper\Compressors\GzipCompressor;

abstract class DumperBackup
{
    /**
     * @var \Spatie\DbDumper\DbDumper
     */
    protected $dumper;

    /**
     * @var string
     */
    protected $destinationPath;

    /**
     * @var DumperDatabaseInfo
     */
    protected $dumperDatabaseInfo;

    /**
     * @var array
     */
    protected $files = [];

    /**
     * DumperBackup constructor.
     *
     * @param DumperDatabaseInfo $dumperDatabaseInfo
     * @param string             $destinationPath
     *
     * @throws \Spatie\DbDumper\Exceptions\CannotSetParameter
     * @throws Exception
     */
    public function __construct(DumperDatabaseInfo $dumperDatabaseInfo, string $destinationPath)
    {
        $this->dumperDatabaseInfo = $dumperDatabaseInfo;

        $this->destinationPath = $destinationPath;

        if (File::ensureDirectoryExists($this->destinationPath, 0755, true) === false) {
            throw new Exception('Destination path is not valid');
        }

        $this->dumper = DumperDriverFactory::create($dumperDatabaseInfo->connection)
            ->setDbName($dumperDatabaseInfo->database)
            ->setUserName($dumperDatabaseInfo->username)
            ->setHost($dumperDatabaseInfo->host)
            ->setPassword($dumperDatabaseInfo->password)
            ->setPort($dumperDatabaseInfo->port)
            ->setDumpBinaryPath($dumperDatabaseInfo->dumpBinaryPath);

        if ($dumperDatabaseInfo->options->withCompression === true) {
            $this->dumper->useCompressor(new GzipCompressor());
        }

        if (count($dumperDatabaseInfo->options->excludeTables) > 0) {
            $this->dumper->excludeTables($dumperDatabaseInfo->options->excludeTables);
        }

        if (count($dumperDatabaseInfo->options->includeTables) > 0) {
            $this->dumper->includeTables($dumperDatabaseInfo->options->includeTables);
        }

        if ($dumperDatabaseInfo->options->withData === false) {
            $this->dumper->addExtraOption('--no-data');
        }

        $this->dumper->addExtraOption($dumperDatabaseInfo->options->extraOption);
    }

    public function backup()
    {
        throw new \Exception('Backup must be implemented');
    }
}
