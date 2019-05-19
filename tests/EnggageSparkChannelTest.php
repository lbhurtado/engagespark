<?php

namespace LBHurtado\EngageSpark\Tests;

use Mockery;
use LBHurtado\EngageSpark\EngageSpark;
use Illuminate\Support\Facades\Notification;
use LBHurtado\EngageSpark\EngageSparkChannel;
use LBHurtado\EngageSpark\Notifications\AdhocNotification;

class EngageSparkChannelTest extends TestCase
{
    /** @var Mockery\Mock */
    protected $engagespark;

    /** @var LBHurtado\EngageSpark\EngageSparkChannel */
	protected $channel;

    public function setUp(): void
    {
        parent::setUp();
    	
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
        $this->engagespark->shouldReceive('getOrgId')->once()->andReturn('7858');
        $this->engagespark->shouldReceive('getSenderId')->once()->andReturn('INFO');
        $this->engagespark->shouldReceive('send')->once();

        $this->channel->send($this->testUser, new AdhocNotification('test message'));

        $this->assertTrue(true);
    }
}
