<?php

namespace SebastienFontaine\Dumper\Modules\Entities;

class DumperUploadInfo
{
    /** @var bool */
    public $enabled;

    /** @var string */
    public $cloudPath;

    /** @var string */
    public $cloudDisk;

    /** @var string */
    public $cloudVisibility;

    /**
     * DumperUploadInfo constructor.
     *
     * @param array $configurations
     */
    public function __construct(array $configurations = [])
    {
        $this->enabled         = $configurations['enabled'] ?? false;
        $this->cloudPath       = $configurations['cloud_path'] ?? '';
        $this->cloudDisk       = $configurations['cloud_disk'] ?? '';
        $this->cloudVisibility = $configurations['cloud_visibility'] ?? 'private';
    }
}
