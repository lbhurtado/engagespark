<?php

namespace LBHurtado\EngageSpark\Tests;

use Illuminate\Support\Str;
use LBHurtado\EngageSpark\EngageSpark;

class EngageSparkTest extends TestCase
{
    /** @var \LBHurtado\EngageSpark\EngageSpark */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(EngageSpark::class);
    }

    /** @test */
    public function service_has_default_public_properties()
    {
        $this->assertSame(config('engagespark.org_id'),    $this->service->getOrgId());
        $this->assertSame(config('engagespark.sender_id'), $this->service->getSenderId());
    }

//    /** @test */
    public function it_sends_a_message()
    {
        $this->service->send([
            'organization_id' => $this->service->getOrgId(),
            'mobile_numbers'  => ['639166342969'],
            'message'         => 'topup soon',
            'recipient_type'  => 'mobile_number',
            'sender_id'       => $this->service->getSenderId(),
        ], 'sms');
    }

//    /** @test */
    public function it_topups_an_amount()
    {
        $this->service->send([
            'organizationId'  => $this->service->getOrgId(),
            'phoneNumber'     => '639166342969',
            'maxAmount'       => 25,
            'clientRef'       => Str::random(5),
        ], 'topup');
    }
}
