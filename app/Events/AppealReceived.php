<?php

namespace App\Events;

use App\Models\Appeal;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppealReceived
{
    use SerializesModels;

    public Appeal $appeal;

    /**
     * Create a new event instance.
     */
    public function __construct(Appeal $appeal)
    {
        $this->appeal = $appeal;
    }
}
