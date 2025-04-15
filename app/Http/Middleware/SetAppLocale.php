<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetAppLocale
{
    public function handle($request, Closure $next)
    {
        if ($request->is('translations') || $request->is('translations/*')) {
            return $next($request);
        }        

        $locale = $request->segment(1);

        if (in_array($locale, ['ru', 'en'])) {
            App::setLocale($locale);
        } else {
            $locale = config('app.fallback_locale');
            App::setLocale($locale);
        }

        $locales = [
            'ru' => 'ru_RU.UTF-8',
            'en' => 'en_US.UTF-8',
        ];

        if (!setlocale(LC_TIME, $locales[$locale] ?? 'C')) {
            logger()->error("Не удалось установить локаль времени для языка: $locale");
        }

        return $next($request);
    }
}
