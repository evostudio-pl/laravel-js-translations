<?php

namespace EvoStudio\JsTranslations;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use SplFileInfo;

class JsTranslations
{

    const CACHE_KEY = 'APP_JS_TRANSLATIONS';

    public static function translations(): array
    {
        $translations = collect();

        foreach (self::retrieveTranslationsLocales() as $locale) {
            $translations[$locale] = [
                'php' => self::phpTranslations($locale),
                'json' => self::jsonTranslations($locale),
            ];
        }

        return $translations->toArray();
    }

    private static function phpTranslations($locale): array
    {
        $dir = self::resourcePath("lang/$locale");

        if (! self::isReadableDir($dir)) {
            return [];
        }

        return collect(File::allFiles($dir))->flatMap(function ($file) use ($locale) {
            $key = ($translation = $file->getBasename('.php'));

            return [
                $key => Lang::get($translation, [], $locale)
            ];
        })->toArray();
    }

    private static function jsonTranslations($locale): array
    {
        $path = self::resourcePath("lang/$locale.json");

        if (is_string($path) && is_readable($path)) {
            return (array) json_decode(file_get_contents($path), true);
        }

        return [];
    }

    private static function retrieveTranslationsLocales(): array
    {
        $localesDir = self::resourcePath("lang");

        if (! self::isReadableDir($localesDir)) {
            return [];
        }

        $dirsLocales = collect(File::directories($localesDir))
            ->map(fn ($path) => basename($path))
            ->filter()
            ->toArray();

        $filesLocales = collect(File::files($localesDir))
            ->map(fn (SplFileInfo $file) => $file->getBasename('.json'))
            ->filter()
            ->toArray();

        return array_unique([
            ...$dirsLocales,
            ...$filesLocales
        ]);
    }

    private static function isReadableDir(string $path): bool
    {
        return is_dir($path) && is_readable($path);
    }

    private static function resourcePath(string $path = ''): string
    {
        return __DIR__ . '/../resources/lang' . $path;
    }
}
