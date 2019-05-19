<?php

namespace LBHurtado\EngageSpark\Notifications;


class Topup extends BaseNotification
{
    /** @var int  */
    protected $amount = 15;

    public function __construct($amount = 0)
    {
        parent::__construct();

        $this->amount = $amount > $this->amount ? $amount : $this->amount;
    }

    public function getContent($notifiable)
    {
        return $this->amount;
    }
}
