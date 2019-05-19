<?php

namespace LBHurtado\EngageSpark\Notifications;


class Topup extends BaseNotification
{
    /** @var int  */
    protected $amount = 15;

    public function getContent($notifiable)
    {
        return $this->amount;
    }
}
