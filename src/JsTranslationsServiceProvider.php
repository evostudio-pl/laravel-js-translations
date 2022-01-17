<?php

namespace EvoStudio\JsTranslations;

use EvoStudio\JsTranslations\Commands\{
    CacheCommand,
    ClearCommand
};
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class JsTranslationsServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->resolved('blade.compiler')) {
            $this->registerDirective($this->app['blade.compiler']);
        } else {
            $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
                $this->registerDirective($bladeCompiler);
            });
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                CacheCommand::class,
                ClearCommand::class
            ]);
        }
    }

    protected function registerDirective(BladeCompiler $bladeCompiler): void
    {
        $bladeCompiler->directive('translations', fn() => "<?php echo app('" . TranslationsDataGenerator::class . "')->generate(); ?>");
    }
}
