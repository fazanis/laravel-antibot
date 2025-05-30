# Laravel antibot MoonShine

## Installation
```
composer require fazanis/laravel-antibot
```
## Publish config
```
php artisan vendor:publish --provider="Fazanis\LaravelAntibot\Providers\LaravelAntibotServiceProvider"
```

```
php artisan migrate
```

### MoonShine
if you use the [MoonShine](https://moonshine-laravel.com), then publish the resource with this command
```
php artisan antibot:moonshine
```
