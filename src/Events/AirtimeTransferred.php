<?php

namespace LBHurtado\EngageSpark\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use  LBHurtado\EngageSpark\Classes\TopupHttpApiParams;

class AirtimeTransferred
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var TopupHttpApiParams */
    public $params;

    /**
     * Create a new event instance.
     *
     * @param TopupHttpApiParams $params
     */
    public function __construct(TopupHttpApiParams $params)
    {
        $this->params = $params;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
