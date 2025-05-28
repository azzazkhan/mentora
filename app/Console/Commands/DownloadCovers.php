<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Modules\Classroom\Enums\Classroom\Cover;
use Throwable;

class DownloadCovers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:download-covers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        collect(Cover::cases())
            ->each(function (Cover $cover) {
                // Get file name from url
                $url = $cover->getOriginalUrl();
                $filename = basename(parse_url($url, PHP_URL_PATH));

                try {
                    Http::sink(public_path("images/covers/{$filename}"))->get($url);

                    $this->components->info('Downloaded cover: ' . $url);
                } catch (Throwable) {
                    $this->components->error('Unable to download cover: ' . $url);
                }
            });
    }
}
