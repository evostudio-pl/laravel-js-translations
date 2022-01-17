<?php

namespace EvoStudio\JsTranslations;

use Illuminate\Support\Facades\Cache;

class JsTranslationsDataGenerator
{
    public function generate()
    {
        $translations = json_encode(Cache::get(
            JsTranslations::CACHE_KEY,
            JsTranslations::translations()
        ));

        $appLocale = json_encode(app()->getLocale());
        $transHelperFunction = $this->getTransHelperFunction();

        return <<<HTML
            <script type="text/javascript">
                const JsTranslations = {
                    locale: $appLocale,
                    translations: $translations
                };

                $transHelperFunction
            </script>
        HTML;
    }

    private function getTransHelperFunction(): string|false
    {
        return file_get_contents($this->getTransHelperFunctionFilePath());
    }

    private function getTransHelperFunctionFilePath():string
    {
        return __DIR__ . '/js/trans.js';
    }
}