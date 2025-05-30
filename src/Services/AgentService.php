<?php

namespace Fazanis\LaravelAntibot\Services;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class AgentService
{
    protected $agent;
    public function __construct(Request $request)
    {
        $this->agent = new Agent();
        $this->agent->setUserAgent($request->server('HTTP_USER_AGENT'));
    }

    public function get(): Agent
    {
        return $this->agent;
    }
}
