<?php

namespace Fazanis\LaravelAntibot\Rules;

use Fazanis\LaravelAntibot\Models\AntibotBotList;
use Fazanis\LaravelAntibot\Models\AntibotLog;
use Fazanis\LaravelAntibot\Models\BotsLog;
use Fazanis\LaravelAntibot\Services\AgentService;
use Fazanis\LaravelAntibot\Services\LaravelAntibotInterface;
use Jenssegers\Agent\Agent;

class IsBotBlockRules implements LaravelAntibotInterface
{
    public function __construct(protected AgentService $agentService){}

    public function check()
    {
        $agent = $this->agentService->get();
        $ip = request()->ip();
        $user_agent = request()->server('HTTP_USER_AGENT');

        $bot = AntibotBotList::query()->firstOrCreate(
            ['bot_name'=>$agent->robot()!=false ? $agent->robot() : 'user']);
        $log = $bot->bots()->firstOrCreate([
            'ip' => $ip,'user_agent' => $user_agent,
        ]);


        $log->increment('visits');
        if ($bot->is_block){
            return 'block';
        }
        return null;
    }

}
