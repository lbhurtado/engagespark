<?php

namespace LBHurtado\EngageSpark\Classes;

use LBHurtado\EngageSpark\EngageSpark;
use LBHurtado\Common\Contracts\HttpApiParams;

class TopupHttpApiParams implements HttpApiParams
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
     * @var int
     */
    protected $amount;

    /**
     * @var string
     */
    protected $recipientType = 'mobile_number';

    /**
     * @var string
     */
    protected $reference;

    /**
     * SendParams constructor.
     * @param $service
     * @param $mobile_number
     * @param $amount
     * @param $reference
     */
    public function __construct(EngageSpark $service, string $mobile, int $amount, string $reference)
    {
        $this->service = $service;
        $this->mobile = $mobile;
        $this->amount = $amount;
        $this->reference = $reference;
    }

    //TODO: make this independent of provider, right now it's engagespark
    public function toArray(): array
    {
        return [
            'organizationId' => $this->service->getOrgId(),
            'phoneNumber' => $this->mobile,
            'maxAmount' => $this->amount,
            'clientRef'  => $this->reference,
        ];
    }
}
