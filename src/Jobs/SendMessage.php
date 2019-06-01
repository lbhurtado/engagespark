<?php

namespace LBHurtado\EngageSpark\Jobs;

use Illuminate\Bus\Queueable;
use LBHurtado\EngageSpark\EngageSpark;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use LBHurtado\EngageSpark\Classes\SendHttpApiParams;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const MODE = 'sms';

    /** @var SendHttpApiParams */
    public $params;

    /**
     * SendMessage constructor.
     * @param SendHttpApiParams $params
     */
    public function __construct(SendHttpApiParams $params)
    {
        $this->params = $params;
    }

    /**
     * @param EngageSpark $service
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(EngageSpark $service)
    {
        $service->send($this->params->toArray(), self::MODE);
    }
}
