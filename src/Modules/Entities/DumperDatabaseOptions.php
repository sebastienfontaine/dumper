<?php

namespace SebastienFontaine\Dumper\Modules\Entities;

class DumperDatabaseOptions
{
    /** @var bool */
    public $withCompression = false;

    /** @var array */
    public $includeTables;

    /** @var array */
    public $excludeTables;

    /** @var string */
    public $cron;

    /** @var string */
    public $suffix;

    /** @var int */
    public $retry;

    /** @var string */
    public $extraOption;

    /** @var array */
    public $separateBackups;

    /** @var bool */
    public $withData;

    /** @var string */
    public $heartbeatUrl;

    /** @var DumperUploadInfo */
    public $uploadInfo;

    /**
     * DumperDatabase constructor.
     *
     * @param array $configurations
     */
    public function __construct(array $configurations)
    {
        $this->suffix          = $configurations['suffix'] ?? '';
        $this->withCompression = $configurations['with_compression'] ?? true;
        $this->includeTables   = $configurations['include_tables'] ?? [];
        $this->excludeTables   = $configurations['exclude_tables'] ?? [];
        $this->cron            = $configurations['cron'] ?? '';
        $this->retry           = $configurations['retry'] ?? 0;
        $this->extraOption     = $configurations['extra_option'] ?? '';
        $this->withData        = $configurations['with_data'] ?? true;
        $this->heartbeatUrl    = $configurations['heartbeat_url'] ?? null;
        $this->separateBackups = [];
        $this->uploadInfo      = new DumperUploadInfo($configurations['upload'] ?? []);

        if (isset($configurations['separate_backups']) === false) {
            return;
        }

        foreach ($configurations['separate_backups'] as $separateBackupInfo) {
            $this->separateBackups[] = new DumperDatabaseSeparateOptions($separateBackupInfo);
        }
    }
}
