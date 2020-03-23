<?php

namespace SebastienFontaine\Dumper\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File as FileManipulation;
use Illuminate\Support\Facades\Storage;
use SebastienFontaine\Dumper\Modules\Entities\DumperDatabaseInfo;

class DumperUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    public $tries = 5;

    /** @var DumperDatabaseInfo */
    protected $dumperDatabaseInfo;

    /** @var string */
    protected $filePath;

    /**
     * DumperUploadJob constructor.
     *
     * @param DumperDatabaseInfo $dumperDatabaseInfo
     * @param string             $filePath
     */
    public function __construct(DumperDatabaseInfo $dumperDatabaseInfo, string $filePath)
    {
        $this->dumperDatabaseInfo = $dumperDatabaseInfo;
        $this->filePath           = $filePath;

        $this->onQueue(config('dumper.upload_queue'));
    }

    public function handle()
    {
        $backupFile = new File($this->filePath);

        $cloudPath = $this->dumperDatabaseInfo->options->uploadInfo->cloudPath . '/' . $backupFile->getFilename();

        $filePath = Storage::disk($this->dumperDatabaseInfo->options->uploadInfo->cloudDisk)
            ->putFileAs(
                '',
                $backupFile,
                $cloudPath,
                [
                    'visibility' => $this->dumperDatabaseInfo->options->uploadInfo->cloudVisibility
                ]
            );

        if ($filePath !== false) {
            FileManipulation::delete($this->filePath);
        }
    }
}
