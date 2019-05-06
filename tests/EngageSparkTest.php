<?php

namespace LBHurtado\EngageSpark\Tests;

use LBHurtado\EngageSpark\EngageSpark;

class EngageSparkTest extends TestCase
{
    /** @test */
    public function service_has_default_properties()
    {
        tap(app(EngageSpark::class), function ($service) {
            $this->assertSame(config('engagespark.end_points.sms'), $service->getEndPoint('sms'));
            $this->assertSame(config('engagespark.end_points.topup'), $service->getEndPoint('topup'));
            $this->assertSame(config('engagespark.web_hooks.sms'), $service->getWebHook('sms'));
            $this->assertSame(config('engagespark.web_hooks.topup'), $service->getWebHook('topup'));
            $this->assertSame(config('engagespark.sender_id'), $service->getSenderId());
        });
    }
}
