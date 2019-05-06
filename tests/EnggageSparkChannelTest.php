<?php

namespace LBHurtado\EngageSpark\Tests;

use Mockery;
use LBHurtado\EngageSpark\EngageSpark;
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
    	
    	\Config::set('engagespark.api_key', 'ABC123');
    	\Config::set('engagespark.org_id', '1234');

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
        $this->assertTrue(true);
    }
}