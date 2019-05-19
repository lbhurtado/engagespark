<?php

namespace LBHurtado\EngageSpark\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use LBHurtado\EngageSpark\EngageSparkMessage;

abstract class BaseNotification extends Notification
{
    use Queueable;

    /** @var int  */
    protected $amount = 0;

    /** @var string */
    protected $message;


    public function __construct($message = null)
    {
        $this->message = $message;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
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
            'mode' => $this->getMode($notifiable)
        ];
    }

    public function toEngageSpark($notifiable)
    {
        return (new EngageSparkMessage())
            ->content($this->getContent($notifiable))
            ->mode($this->getMode($notifiable))
            ->transfer($this->getAmount($notifiable))
            ;
    }

    public function getContent($notifiable)
    {
        return $this->amount > 0 ? $this->amount : $this->message;
    }

    protected function getMode($notifiable)
    {
        return $this->amount > 0 ? 'topup' : 'sms';
    }

    protected function getAmount($notifiable)
    {
        return $this->amount;
    }
}
