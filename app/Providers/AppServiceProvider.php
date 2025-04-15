<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tag;
use BezhanSalleh\FilamentLanguageSwitch\Enums\Placement;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $categories = ArticleCategory::where('active', true)->get();
            $latestArticles = Article::latest('published_at')->take(3)->get();

            $articleTags = Tag::all()->pluck('title')->unique();

            $view->with('categories', $categories);
            $view->with('latestArticles', $latestArticles);
            $view->with('articleTags', $articleTags);
        });
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ru','en'])
                ->visible(outsidePanels: true)
                ->outsidePanelRoutes([
                    'personal',
                ])
                ->circular()
                ->outsidePanelPlacement(Placement::TopRight);
        });
        Request::macro('pathWithoutLocale', function () {
            return preg_replace('#^' . app()->getLocale() . '/?#', '', $this->path());
        });
    }
}
