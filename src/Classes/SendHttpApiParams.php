<?php

namespace LBHurtado\EngageSpark\Classes;

use Illuminate\Support\Arr;
use LBHurtado\EngageSpark\EngageSpark;
use Propaganistas\LaravelPhone\PhoneNumber;
use LBHurtado\Common\Contracts\HttpApiParams;

class SendHttpApiParams implements HttpApiParams
{
    /**
     * @var EngageSpark
     */
    protected $service;

    /**
     * @var string
     */
    protected $mobile;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $senderId;

    /**
     * @var string
     */
    protected $recipientType = 'mobile_number';

    /**
     * SendParams constructor.
     * @param $service
     * @param $mobile
     * @param $message
     */
    public function __construct(EngageSpark $service, string $mobile, string $message, string $senderId = null)
    {
        $this->service = $service;
        $this->mobile = $mobile;
        $this->message = $message;
        $this->setSenderId($service, $senderId);
    }

    public function toArray(): array
    {
        return [
            'orgId' => $this->service->getOrgId(),
            'to' => $this->getFormattedMobile(),
            'from' => $this->senderId,
            'message' => $this->message,
        ];
    }

    protected function setSenderId(EngageSpark $service, string $senderId = null)
    {
        $this->senderId = $senderId ?? $service->getSenderId();

        return $this;
    }

    protected function getFormattedMobile()
    {
        return tap((new PhoneNumber('09173011987', 'PH'))->formatE164(), function(&$recipient) {
            $recipient = preg_replace('/\D/', '', $recipient);
        });
    }
}
