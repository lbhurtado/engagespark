<?php

namespace LBHurtado\EngageSpark\Tests;

use Mockery;
use LBHurtado\EngageSpark\EngageSpark;
use Illuminate\Support\Facades\Notification;
use LBHurtado\EngageSpark\EngageSparkChannel;

class EngageSparkChannelTest extends TestCase
{
    /** @var Mockery\Mock */
    protected $engagespark;

    /** @var LBHurtado\EngageSpark\EngageSparkChannel */
	protected $channel;

    public function setUp(): void
    {
        parent::setUp();
    	
    	\Config::set('engagespark.api_key', 'b3867ab758b3fea05a4f40124e0e4f52c399ed12');
    	\Config::set('engagespark.org_id', '7858');

        $this->engagespark = Mockery::mock(EngageSpark::class);
        $this->channel = new EngageSparkChannel($this->engagespark);
    }

    public function tearDown(): void
    {
        Mockery::close();
    
        parent::tearDown();
    }

    /** @test */
    public function it_can_send_a_notification()
    {
    	Notification::fake();

    	$this->testUser->notify(new TestNotification());

        Notification::assertSentTo($this->testUser, TestNotification::class);
        $this->assertTrue(true);
    }
}