<?php

namespace Fazanis\LaravelAntibot\Rules;

use Fazanis\LaravelAntibot\Services\AgentService;
use Fazanis\LaravelAntibot\Services\LaravelAntibotInterface;
use Jenssegers\Agent\Agent;

class IsCaptchaPassedRules implements LaravelAntibotInterface
{
    public function __construct(protected AgentService $agentService){}

    public function check()
    {

        if ($this->agentService->get()->isBot()){
            return null;
        }

        if(request()->server('HTTP_REFERER')) {
            return null;
        }
        if(request()->server('HTTP_USER_AGENT')) {
            return null;
        }

        if (request()->session()->get('captcha_passed')!==true) {
            return 'captcha';
        }
        return null;
    }

}
