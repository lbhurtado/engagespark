<?php

namespace LBHurtado\EngageSpark\Notifications;

class Adhoc extends BaseNotification
{
    public function getContent($notifiable)
    {
        return $this->message;
    }
}
