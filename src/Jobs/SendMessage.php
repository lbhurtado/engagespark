<?php

namespace LBHurtado\EngageSpark\Jobs;

use Illuminate\Bus\Queueable;
use LBHurtado\EngageSpark\EngageSpark;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use LBHurtado\EngageSpark\Classes\ServiceMode;
use LBHurtado\EngageSpark\Classes\SendHttpApiParams;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var string */
    public $mobile;

    /** @var string */
    public $message;

    /** @var SendHttpApiParams */
    public $params;

    /**
     * SendMessage constructor.
     * @param string $mobile
     * @param string $message
     */
    public function __construct($mobile, $message)
    {
        $this->mobile = $mobile;
        $this->message = $message;
    }

    /**
     * @param EngageSpark $service
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(EngageSpark $service)
    {
        $service->send($this->getParams($service)->toArray(), ServiceMode::SMS);
    }

    public function getParams(EngageSpark $service)
    {
        return new SendHttpApiParams($service, $this->mobile, $this->message);
    }
}
