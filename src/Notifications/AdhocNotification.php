<?php

namespace LBHurtado\EngageSpark\Notifications;


class AdhocNotification extends BaseNotification
{

    public function getContent($notifiable)
    {
        return $this->message;
    }
}
