<?php

namespace LBHurtado\EngageSpark\Tests;

use LBHurtado\EngageSpark\EngageSparkMessage;
use LBHurtado\EngageSpark\Classes\ServiceMode;

class EngageSparkMessageTest extends TestCase
{
	/** @var EngageSparkMessage */
	protected $message;

   	public function setUp(): void
    {
        parent::setUp();

        $this->message = new EngageSparkMessage;
    }

    /** @test */
    public function can_automatically_set_content_property_during_instantation()
    {
    	$content = "The quick brown fox...";
    	$message = new EngageSparkMessage($content);

    	$this->assertEquals($message->content, $content);
    }

    /** @test */
    public function can_manually_set_content_property_after_instantation()
    {
    	$content = "The quick brown fox...";
    	$msg = $this->message->content($content);

    	$this->assertEquals($this->message->content, $content);
    	$this->assertSame($msg, $this->message);
    }

    /** @test */
    public function can_automatically_set_sms_mode_property_automatically_after_instantation()
    {
    	$mode = ServiceMode::SMS;
    	$this->assertEquals($this->message->mode, $mode);
    }

    /** @test */
    public function can_manually_set_mode_property_after_instantation()
    {
    	$mode = ServiceMode::TOPUP;
    	$msg = $this->message->mode($mode);

    	$this->assertEquals($this->message->mode, $mode);
    	$this->assertSame($msg, $this->message);
    }

    /** @test */
    public function can_manually_set_from_property_after_instantation()
    {
    	$from = "+639171234567";
    	$msg = $this->message->from($from);

    	$this->assertEquals($this->message->from, $from);
    	$this->assertSame($msg, $this->message);
    }

    /** @test */
    public function can_manually_set_sender_id_property_after_instantation()
    {
    	$sender_id = "INFO";
    	$msg = $this->message->sender_id($sender_id);

    	$this->assertEquals($this->message->sender_id, $sender_id);
    	$this->assertSame($msg, $this->message);
    }

    /** @test */
    public function can_manually_set_air_time_property_after_instantation()
    {
    	$amount = 20;
    	$msg = $this->message->transfer($amount);

    	$this->assertEquals($this->message->air_time, $amount);
    	$this->assertSame($msg, $this->message);
    }

    /** @test */
    public function can_automatically_set_mobile_number_recipient_type__property_automatically_after_instantation()
    {
    	$this->assertEquals($this->message->recipient_type, "mobile_number");
    }
}