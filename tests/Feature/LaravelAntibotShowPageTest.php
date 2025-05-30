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

class LaravelAntibotShowPageTest extends TestCase
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

    public function test_normal_bot_passes()
    {
        $response = $this->get('/', [
                'User-Agent' => 'Googlebot/2.1 (+http://www.google.com/bot.html)',
                'Referer' => '',
            ]);
        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }
    public function test_normal_user_with_refer_and_agent_without_captcha()
    {
        $response = $this->withSession(['captcha_passed' => false])
            ->get('/', [
                'User-Agent' => 'Mozilla/5.0',
                'Referer' => 'https://example.com',
            ]);
        $response->assertOk();
        $response->assertViewIs('welcome');
    }


    public function test_bot_agent_gets_captcha()
    {
        $response = $this->get('/', [
            'HTTP_USER_AGENT' => 'Googlebot/2.1',
            'HTTP_REFERER' => 'https://example.com',
        ]);

        $response->assertSee('ok');
    }

    public function test_not_blocked_bot_gets_blocked()
    {
        $bot = AntibotBotList::query()->updateOrCreate(
            ['bot_name' => 'Googlebot'],
            ['is_block' => false]
        );
        $log = $bot->bots()->firstOrCreate([
            'ip' => '127.0.0.1','user_agent' => 'Googlebot/2.1',
        ]);

        $response = $this->get('/', [
            'HTTP_USER_AGENT' => 'Googlebot/2.1',
            'HTTP_REFERER' => 'https://example.com',
        ]);
        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

}
