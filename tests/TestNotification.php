<?php

namespace LBHurtado\EngageSpark\Tests;

use Illuminate\Notifications\Notification;
use LBHurtado\EngageSpark\EngageSparkChannel;
use LBHurtado\EngageSpark\EngageSparkMessage;

class TestNotification extends Notification
{
    public function via($notifiable)
    {
        return [EngageSparkChannel::class];
    }

    public function toEngageSpark($notifiable)
    {
        return (new EngageSparkMessage())
            ->content('test message')
            ;
    }
}