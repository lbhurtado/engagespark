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

    protected $service;

    protected $mobile;

    protected $message;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = Mockery::mock(EngageSpark::class);
        $this->mobile = $this->faker->phoneNumber;
        $this->message = $this->faker->sentence;       
    }

	/** @test */
	public function job_can_send_message_with_sender_id()
	{
        /*** arrange ***/
        $senderId = $this->faker->word; 
        $job = new SendMessage($this->mobile, $this->message, $senderId);

        /*** assert ***/
        $this->service->shouldReceive('getOrgId')->once();
        $this->service->shouldReceive('send')->once();

        /*** act ***/
        $job->handle($this->service);

        /*** assert ***/
        $this->assertEquals($this->mobile, $job->mobile);
        $this->assertEquals($this->message, $job->message);
        $this->assertEquals($senderId, $job->senderId);
	}

    /** @test */
    public function job_can_send_message_without_sender_id()
    {
        /*** arrange ***/
        $job = new SendMessage($this->mobile, $this->message);

        /*** assert ***/
        $this->service->shouldReceive('getOrgId')->once();
        $this->service->shouldReceive('getSenderId')->once();
        $this->service->shouldReceive('send')->once();

        /*** act ***/
        $job->handle($this->service);

         /*** assert ***/
        $this->assertEquals($this->mobile, $job->mobile);
        $this->assertEquals($this->message, $job->message);
    }
}
