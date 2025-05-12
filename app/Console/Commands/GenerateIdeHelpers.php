<?php

namespace App\Console\Commands;

use Composer\InstalledVersions;
use Illuminate\Console\Command;

class GenerateIdeHelpers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate-ide-helpers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates IDE helpers if required packages are installed';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (!InstalledVersions::isInstalled('barryvdh/laravel-ide-helper') || !config('ide-helper.enabled')) {
            return;
        }

        $this->call('ide-helper:generate', [
            '--write_mixins' => true,
            '--helpers',
            '--memory',
        ]);

        $this->call('ide-helper:models');
        $this->call('ide-helper:meta');
    }
}
