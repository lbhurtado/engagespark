<?php

namespace LBHurtado\EngageSpark\Jobs;

use Illuminate\Bus\Queueable;
use LBHurtado\EngageSpark\EngageSpark;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use  LBHurtado\EngageSpark\Classes\TopupHttpApiParams;

class TransferAirtime implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const MODE = 'topup';

    /** @var TopupHttpApiParams */
    public $params;

    /**
     * TopupAmount constructor.
     * @param TopupHttpApiParams $params
     */
    public function __construct(TopupHttpApiParams $params)
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
