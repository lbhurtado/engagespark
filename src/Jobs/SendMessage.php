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

    /** @var EngageSpark */
    public $service;

    /**
     * SendMessage constructor.
     * @param string $mobile
     * @param string $message
     */
    public function __construct(string $mobile, string $message)
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
        $this->setService($service)->send();
    }

    protected function send()
    {
        tap(new SendHttpApiParams($this->service, $this->mobile, $this->message), function ($params) {
            $this->service->send($params->toArray(), ServiceMode::SMS);    
        });
    }

    protected function setService(EngageSpark $service)
    {
        $this->service = $service;

        return $this;
    }
}
