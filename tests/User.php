<?php

namespace LBHurtado\EngageSpark\Tests;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    protected $fillable = ['mobile'];

    public function routeNotificationForEngageSpark()
    {
        return $this->mobile;
    }
}