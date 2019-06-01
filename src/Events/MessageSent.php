<?php

namespace LBHurtado\EngageSpark\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use LBHurtado\EngageSpark\Classes\SendHttpApiParams;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class MessageSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var SendHttpApiParams */
    public $params;

    /**
     * Create a new event instance.
     *
     * @param SendHttpApiParams $params
     */
    public function __construct(SendHttpApiParams $params)
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