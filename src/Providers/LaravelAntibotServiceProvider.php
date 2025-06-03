<?php

namespace Fazanis\LaravelAntibot\Providers;

use Fazanis\LaravelAntibot\Console\Commands\MoonShineCommand;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Contracts\MenuManager\MenuManagerContract;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use MoonShine\UI\Components\ActionButton;

class LaravelAntibotServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(CoreContract $core,MenuManagerContract $menu): void
    {

        $this->publishes([
            __DIR__.'/../../config/laravel-antibot.php' => config_path('laravel-antibot.php')
        ], 'block-bots');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../../resources/views/bots', 'bots');
        $this->loadRoutesFrom(__DIR__.'/../../routes/laravel-antibot.php');
        config()->set('captcha.math', true);
        if ($this->app->runningInConsole()) {
            $this->commands([
                MoonShineCommand::class,
            ]);
        }
    }
}
