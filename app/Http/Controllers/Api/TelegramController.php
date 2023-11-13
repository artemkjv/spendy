<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class TelegramController extends Controller
{
    public function index()
    {
        $bot = new \TelegramBot\Api\Client(config('telegram.token'));
        $bot->command('start', function ($message) use ($bot) {
            $chatId = $message->getChat()->getId();

            $bot->sendMessage($message->getChat()->getId(), 'Ви запустили бота!');
        });
        $bot->run();

    }
}
