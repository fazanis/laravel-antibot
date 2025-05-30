<?php

namespace Fazanis\LaravelAntibot\Rules;

use Fazanis\LaravelAntibot\Services\AgentService;
use Fazanis\LaravelAntibot\Services\LaravelAntibotInterface;
use Jenssegers\Agent\Agent;

class IsNotReferRules implements LaravelAntibotInterface
{
    public function __construct(protected AgentService $agentService){}

    public function check()
    {
        if (!$this->agentService->get()->isBot() && request()->server('HTTP_REFERER') === null) {
            return 'captcha';
        }
        return null;
    }

}
