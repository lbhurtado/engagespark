<?php

namespace LBHurtado\EngageSpark\Classes;

use Illuminate\Support\Arr;
use LBHurtado\EngageSpark\EngageSpark;
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
    protected $recipientType = 'mobile_number';

    /**
     * SendParams constructor.
     * @param $service
     * @param $mobile
     * @param $message
     */
    public function __construct(EngageSpark $service, string $mobile, string $message) //TODO: add sender_id
    {
        $this->service = $service;
        $this->mobile = $mobile;
        $this->message = $message;
    }

    public function toArray(): array
    {
        return [
            'organization_id' => $this->service->getOrgId(),
            'mobile_numbers' => Arr::wrap($this->mobile),
            'message' => $this->message,
            'sender_id' => $this->service->getSenderId(),
            'recipient_type'  => $this->recipientType,
        ];
    }
}
