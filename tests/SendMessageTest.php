<?php

namespace LBHurtado\EngageSpark\Tests;

use Mockery;
use LBHurtado\EngageSpark\EngageSpark;
use LBHurtado\EngageSpark\Jobs\SendMessage;
use Illuminate\Foundation\Testing\WithFaker;
use LBHurtado\EngageSpark\Classes\SendHttpApiParams;

class SendMessageTest extends TestCase
{
    use WithFaker;

	/** @test */
	public function job_can_send_message()
	{
        /*** arrange ***/
        $service = Mockery::mock(EngageSpark::class);
        $params = new SendHttpApiParams(
            $service,
            $mobile_number = $this->faker->phoneNumber,
            $message = $this->faker->sentence
        );

        $job = new SendMessage($params);

        /*** assert ***/
        $service->shouldReceive('getOrgId')->once();
        $service->shouldReceive('getSenderId')->once();
        $service->shouldReceive('send')->once();

        /*** act ***/
        $job->handle($service);
	}
}
