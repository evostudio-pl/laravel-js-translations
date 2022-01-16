<?php

namespace EvoStudio\JsTranslations\Commands;

use EvoStudio\JsTranslations\JsTranslations;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CacheCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'js-translations:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache translations';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('translations:clear');

        Cache::rememberForever(
            JsTranslations::CACHE_KEY,
            fn() => JsTranslations::translations()
        );

        $this->info('Translations cached successfully!');
    }
}
