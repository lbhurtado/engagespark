<?php

namespace LBHurtado\EngageSpark\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var string */
    public $mobile;

    /** @var string */
    public $message;

    /** @var string */
    public $senderId;

    /**
     * Create a new event instance.
     *
     * @param string $mobile
     * @param string $message
     * @param string $senderId
     */
    public function __construct(string $mobile, string $message, string $senderId = null)
    {
        $this->mobile = $mobile;
        $this->message = $message;
        $this->senderId = $senderId;
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