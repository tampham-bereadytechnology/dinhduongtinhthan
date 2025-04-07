<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Models\Post;

class RefreshFeedCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:refresh-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Làm mới cache cho RSS feed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        Cache::forget('rss-feed');
        Cache::remember('rss-feed', 60 * 60 * 24, function () {
            return Post::latest()->take(20)->get();
        });
        $this->info('Cache RSS feed đã được làm mới.');
    }
}
