<?php

namespace App\Listeners;

use App\Events\AppealReceived;
use TelegramBot\Api\Client;

class AppealReceivedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AppealReceived $event): void
    {
        $appeal = $event->appeal;
        $bot = new Client(config('telegram.token'));
        $message = <<<MESSAGE
        Ім'я: $appeal->name $appeal->surname,
        Номер телефону: $appeal->phone,
        Електронна адреса: $appeal->email,
        Текст повідомлення: $appeal->comment
        MESSAGE;
        $bot->sendMessage(config('telegram.chat_id'), $message);
    }
}
