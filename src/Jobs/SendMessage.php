<?php

namespace LBHurtado\EngageSpark\Jobs;

use Illuminate\Bus\Queueable;
use LBHurtado\EngageSpark\EngageSpark;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use LBHurtado\Common\Contracts\HttpApiParams;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const MODE = 'sms';

    /** @var HttpApiParams */
    public $params;

    /**
     * SendMessage constructor.
     * @param HttpApiParams $params
     */
    public function __construct(HttpApiParams $params)
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
