<?php

namespace EvoStudio\JsTranslations;

use EvoStudio\JsTranslations\Commands\{
    CacheCommand,
    ClearCommand
};
use Illuminate\Support\Facades\{
    Blade,
    Cache
};
use Illuminate\Support\ServiceProvider;

class JsTranslationsServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerBladeDirective();

        if ($this->app->runningInConsole()) {
            $this->commands([
                CacheCommand::class,
                ClearCommand::class
            ]);
        }
    }

    protected function registerBladeDirective(): void
    {
        $translations = json_encode(Cache::get(
            JsTranslations::CACHE_KEY,
            JsTranslations::translations()
        ));

        Blade::directive('translations', fn() =>
            <<<HTML
                <script type="text/javascript">
                    const translations = {$translations};
                </script>
            HTML
        );
    }
}
