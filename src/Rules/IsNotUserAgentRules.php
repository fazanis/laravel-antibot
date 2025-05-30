<?php

namespace Fazanis\LaravelAntibot\Rules;

use Fazanis\LaravelAntibot\Services\AgentService;
use Fazanis\LaravelAntibot\Services\LaravelAntibotInterface;

class IsNotUserAgentRules implements LaravelAntibotInterface
{
    public function __construct(protected AgentService $agentService){}
    public function check()
    {
        if (!request()->server('HTTP_USER_AGENT')){
            return 'captcha';
        }
        return null;
    }

}
