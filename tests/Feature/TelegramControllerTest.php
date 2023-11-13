<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\TelegramController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Mockery;
use Tests\TestCase;

class TelegramControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndex()
    {
        // Mock the bot client
        $bot = Mockery::mock('overload:TelegramBot\Api\Client');
        $bot->shouldReceive('command')->once()->with('start', \Mockery::type('Closure'));
        $bot->shouldReceive('run')->once();

        // Set the telegram token in the config
        Config::set('telegram.token', 'my_token');

        // Create the controller instance
        $controller = new TelegramController();

        // Call the index method
        $response = $controller->index();
        $this->assertNull($response);
    }
}

