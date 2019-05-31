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
        $params = new SendHttpApiParams(
            $org_id = $this->faker->numberBetween(1000,9999),
            $mobile_number = $this->faker->phoneNumber,
            $message = $this->faker->sentence,
            $sender_id = $this->faker->word
        );
        $service = Mockery::mock(EngageSpark::class);
        $job = new SendMessage($params);

        /*** assert ***/

        $service->shouldReceive('send')->once();

        /*** act ***/
        $job->handle($service);
	}
}
