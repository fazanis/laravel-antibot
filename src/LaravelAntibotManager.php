<?php

namespace Fazanis\LaravelAntibot;

use Fazanis\LaravelAntibot\Models\AntibotLog;
use Fazanis\LaravelAntibot\Services\LaravelAntibotInterface;
use Jenssegers\Agent\Agent;

class LaravelAntibotManager
{


    public function check()
    {
        foreach (config('laravel-antibot.rules') as $ruleClass) {
            $rule = app($ruleClass);
            if (! $rule instanceof LaravelAntibotInterface) continue;
            if($rule->check()!=null){
                return $rule->check();
            }
        }
        return null;
    }

    private function hasAgent()
    {
        return request()->server('HTTP_USER_AGENT')!=null ? true : false;
    }

    private function isBot()
    {
        return $this->agent->isBot();
    }

    protected function storeBotLog()
    {
        $ip = request()->ip();
        $user_agent = request()->server('HTTP_USER_AGENT');

//        dd($user_agent,$ip,$this->isBot());
        $log = AntibotLog::query()->firstOrCreate(
            ['ip' => $ip, 'user_agent' => $user_agent],
            ['ip' => $ip, 'user_agent' => $user_agent,'is_bot'=>$this->isBot()]
        );

        $log->increment('visits');
        return $log;
    }
}
