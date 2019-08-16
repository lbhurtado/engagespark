<?php

namespace LBHurtado\EngageSpark\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AirtimeTransferred
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var string */
    public $mobile;

    /** @var int */
    public $amount;

    /** @var string */
    public $reference;

    /**
     * Create a new event instance.
     *
     * @param string $mobile
     * @param int $amount
     * @param string $reference
     */
    public function __construct($mobile, $amount, $reference)
    {
        $this->mobile = $mobile;
        $this->amount = $amount;
        $this->reference = $reference;
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
