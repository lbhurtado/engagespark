<?php

namespace LBHurtado\EngageSpark\Tests;

use Mockery;
use LBHurtado\EngageSpark\EngageSpark;
use LBHurtado\EngageSpark\Jobs\SendMessage;

class SendMessageTest extends TestCase
{
	/** @test */
	public function job_can_send_message()
	{
		$engagespark = Mockery::mock(EngageSpark::class);

		$job = 
		$this->assertTrue(true);
	}
}