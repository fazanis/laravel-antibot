<?php


use Fazanis\LaravelAntibot\Http\Middleware\LaravelAntibotMiddleware;
use Fazanis\LaravelAntibot\LaravelAntibotManager;
use Fazanis\LaravelAntibot\Models\AntibotBotList;
use Fazanis\LaravelAntibot\Providers\LaravelAntibotServiceProvider;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Tests\TestCase;

class LaravelAntibotShowCaptchaTest extends TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [LaravelAntibotServiceProvider::class];
    }

    protected function defineRoutes($router)
    {
        Route::middleware(['web', LaravelAntibotMiddleware::class])
            ->get('/test', fn() => 'ok');
    }


    public function test_missing_user_agent_gets_captcha()
    {
        $response = $this->withSession(['captcha_passed' => false])
            ->get('/', [
            'User-Agent' => '',
            'Referer' => '',
        ]);

        $response->assertViewIs('bots::captcha'); // или шаблон
    }
    public function test_missing_referer_gets_captcha()
    {
        $response = $this->withSession(['captcha_passed' => false])
            ->get('/', [
                'User-Agent' => 'Mozilla/5.0',
                'Referer' => '',
            ]);

        $response->assertViewIs('bots::captcha');

    }

    public function test_bot_gets_blocked()
    {
        $user_agent = 'Googlebot/2.1 (+http://www.google.com/bot.html)';
        $bot = AntibotBotList::query()->updateOrCreate(
            ['bot_name' => 'Googlebot'],
            ['is_block' => true]
        );
        $bot->bots()->firstOrCreate([
            'ip' => '127.0.0.1','user_agent' => $user_agent,
        ]);

        $response = $this->get('/', [
            'HTTP_USER_AGENT' => $user_agent,
            'HTTP_REFERER' => '',
        ]);
        $response->assertStatus(403);
    }

}
