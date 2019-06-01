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

    protected $service;

    protected $mobile;

    protected $amount;

    protected $reference;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = Mockery::mock(EngageSpark::class);
        $this->mobile = $this->faker->phoneNumber;
        $this->amount = $this->faker->numberBetween(25,100);
        $this->reference = Str::random(5);
    }

    /** @test */
    public function job_can_transfer_airtime()
    {
        /*** arrange ***/
        // $params = new TopupHttpApiParams(
        //     $service,
        //     $mobile = $this->faker->phoneNumber,
        //     $amount = $this->faker->numberBetween(25,100),
        //     $reference = Str::random(5)
        // );
        $job = new TransferAirtime($this->mobile, $this->amount, $this->reference);

        /*** assert ***/
        $this->service->shouldReceive('getOrgId')->once();
        $this->service->shouldReceive('send')->once();

        /*** act ***/
        $job->handle($this->service);

        /*** assert ***/
        $this->assertEquals($this->mobile, $job->mobile);
        $this->assertEquals($this->amount, $job->amount);
        $this->assertEquals($this->reference, $job->reference);
    }
}
