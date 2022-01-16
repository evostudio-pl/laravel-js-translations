<?php

namespace EvoStudio\JsTranslations\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'js-translations:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove translations from cache';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        Cache::forget('APP_TRANSLATIONS');

        $this->info('Translations cache cleared!');
    }
}
