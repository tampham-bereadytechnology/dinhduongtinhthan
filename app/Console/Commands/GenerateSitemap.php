<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Psr\Http\Message\UriInterface;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

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
        //
        $url = config('app.url'); // Lấy từ .env

        SitemapGenerator::create($url)
            ->shouldCrawl(function (UriInterface $url) {
                $path = $url->getPath();

                if (
                    $path == '/login' ||
                    $path == '/admin' ||
                    str_starts_with($path, '/admin/')
                ) {
                    return false;
                }
                return true;
            })
            ->writeToFile(public_path('sitemap.xml')); // Lưu vào disk public, công khai
        $this->info("Sitemap đã được tạo tại: {$url}/sitemap.xml");
    }
}
