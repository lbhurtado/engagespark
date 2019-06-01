<?php

namespace LBHurtado\EngageSpark\Tests;

use Mockery;
use Illuminate\Support\Str;
use LBHurtado\EngageSpark\EngageSpark;
use Illuminate\Foundation\Testing\WithFaker;
use LBHurtado\EngageSpark\Jobs\TransferAirtime;
use LBHurtado\EngageSpark\Classes\TopupHttpApiParams;

class TransferAirtimeTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function job_can_transfer_airtime()
    {
        /*** arrange ***/
        $service = Mockery::mock(EngageSpark::class);
        $params = new TopupHttpApiParams(
            $service,
            $mobile = $this->faker->phoneNumber,
            $amount = $this->faker->numberBetween(25,100),
            $reference = Str::random(5)
        );

        $job = new TransferAirtime($params);

        /*** assert ***/
        $service->shouldReceive('getOrgId')->once();
        $service->shouldReceive('send')->once();

        /*** act ***/
        $job->handle($service);
    }
}
