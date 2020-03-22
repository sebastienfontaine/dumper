<?php

namespace SebastienFontaine\Dumper\Console;

use Illuminate\Console\Command;

class DumperPublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dumper:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all of the Dumper resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Dumper Configuration...');

        $this->callSilent('vendor:publish', ['--tag' => 'dumper-config']);

        $this->info('Dumper published successfully.');
    }
}
