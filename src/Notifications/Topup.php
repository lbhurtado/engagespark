<?php

namespace LBHurtado\EngageSpark\Notifications;


class Topup extends BaseNotification
{
    /** @var int  */
    protected $amount;

    public function __construct($amount = 0)
    {
        parent::__construct();

        $this->amount = max($amount, $this->getMinimumAmount());
    }

    public function getContent($notifiable)
    {
        return $this->amount;
    }

    protected function getMinimumAmount()
    {
        return config('engagespark.topup.minimum');
    }
}
