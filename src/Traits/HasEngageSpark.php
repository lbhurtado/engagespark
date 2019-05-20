<?php

namespace LBHurtado\EngageSpark\Traits;

use Illuminate\Notifications\Notifiable;

trait HasEngageSpark
{
    use Notifiable;

    public function routeNotificationForEngageSpark()
    {
        $field = config('engagespark.notifiable.route');

        return $this->{$field};
    }
}