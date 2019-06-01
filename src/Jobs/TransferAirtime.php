<?php

namespace LBHurtado\EngageSpark\Jobs;

use Illuminate\Bus\Queueable;
use LBHurtado\EngageSpark\EngageSpark;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use LBHurtado\EngageSpark\Classes\ServiceMode;
use  LBHurtado\EngageSpark\Classes\TopupHttpApiParams;

class TransferAirtime implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const MODE = 'topup';

    /** @var string */
    public $mobile;

    /** @var int */
    public $amount;

    /** @var string */
    public $reference;

    /**
     * TopupAmount constructor.
     * @param string $mobile
     * @param int $amount
     * @param string $reference
     */
    public function __construct(string $mobile, int $amount, string $reference)
    {
        $this->mobile = $mobile;
        $this->amount = $amount;
        $this->reference = $reference;
    }

    /**
     * @param EngageSpark $service
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(EngageSpark $service)
    {
        $this->setService($service)->topup();
    }

    protected function topup()
    {
        tap(new TopupHttpApiParams($this->service, $this->mobile, $this->amount, $this->reference), function ($params) {
            $this->service->send($params->toArray(), ServiceMode::TOPUP);    
        });
    }

    protected function setService(EngageSpark $service)
    {
        $this->service = $service;

        return $this;
    }
}
