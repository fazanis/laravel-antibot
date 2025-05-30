<?php

namespace Fazanis\LaravelAntibot\Rules;

use Fazanis\LaravelAntibot\Services\AgentService;
use Fazanis\LaravelAntibot\Services\LaravelAntibotInterface;
use Jenssegers\Agent\Agent;

class IsBotRules implements LaravelAntibotInterface
{
    public function __construct(protected AgentService $agentService){}
    public function check()
    {
        $agent = $this->agentService->get();

        if (!$agent->isRobot() &&
            (!request()->server('HTTP_USER_AGENT') ||
            !request()->server('HTTP_REFERER'))){
            return 'captcha';
        }
        return null;
    }

}
