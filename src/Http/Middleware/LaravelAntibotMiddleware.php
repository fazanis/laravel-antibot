<?php

namespace Fazanis\LaravelAntibot\Http\Middleware;

use Closure;
use Fazanis\LaravelAntibot\LaravelAntibotManager;
use Fazanis\LaravelBlockBots\BlockBots;
use Fazanis\LaravelBlockBots\BlockBotsManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LaravelAntibotMiddleware
{

    protected $manager;
    public function __construct(LaravelAntibotManager $manager)
    {
        $this->manager = $manager;
    }
    public function handle(Request $request, Closure $next): Response
    {
        $excludedPaths = [
            'captcha',
            'captcha/*',
            'captcha_validate',
        ];

        foreach ($excludedPaths as $path) {
            if ($request->is($path)) {
                return $next($request);
            }
        }
        if (config('laravel-antibot.enabled')===true) {

            $result = $this->manager->check();

            return match ($result) {
                'block'   => abort(403, 'Access denied. You are blocked.'),
                'captcha' => response()->view('bots::captcha'),
                default   => $next($request),
            };
        }

        return $next($request);
    }
}
