<?php

namespace LBHurtado\EngageSpark\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use LBHurtado\EngageSpark\EngageSparkMessage;

abstract class BaseNotification extends Notification
{
    use Queueable;

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return config('engagespark.notification.channels');
    }

    public function toArray($notifiable)
    {
        return [
            'mobile' => $notifiable->mobile,
            'message' => $this->getContent($notifiable),
        ];
    }

    public function toEngageSpark($notifiable)
    {
        return (new EngageSparkMessage())
            ->content($this->getContent($notifiable))
            ;
    }

    abstract public function getContent($notifiable);
}
