<?php

namespace Fazanis\LaravelAntibot\Console\Commands;

use Illuminate\Console\Command;

class MoonShineCommand extends Command
{
    protected $signature = 'antibot:moonshine';

    public function handle()
    {

        $stubs = [
            "BotListResource.php"=>"moonshine_antibotlist_resource.stub",
            "BotsLogResource.php"=>"moonshine_antibotlog_resource.stub"
        ];
        $config = app(\MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract::class);


        foreach ($stubs as $resource=>$stub) {

            $resource = $config->getDir() . "/Resources/{$resource}";
            $namespace = $config->getNamespace('\Resources');
            $contents = $this->laravel['files']->get(__DIR__ . "/../../../stubs/{$stub}");
            $contents = str_replace('{namespace}', $namespace, $contents);
            $this->laravel['files']->put(
                $resource,
                $contents
            );
        }




        $this->components->info('Now register resource in menu');
    }
}
