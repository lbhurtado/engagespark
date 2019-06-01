<?php

namespace LBHurtado\EngageSpark\Tests;

use Mockery;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use LBHurtado\EngageSpark\EngageSpark;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Foundation\Testing\WithFaker;
use LBHurtado\EngageSpark\Classes\ServiceMode;
use LBHurtado\EngageSpark\Classes\SendHttpApiParams;
use LBHurtado\EngageSpark\Classes\TopupHttpApiParams;

class EngageSparkTest extends TestCase
{
    use WithFaker;

    /** @var \GuzzleHttp\Client */
    protected $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = Mockery::mock(Client::class);
    }

   /** @test */
    public function service_has_default_public_properties()
    {
        /*** arrange ***/
        $config = config('engagespark');

        /*** act ***/
        $service = new EngageSpark($this->client);

        /*** assert ***/
        $this->assertNotNull($config['org_id']);
        $this->assertNotNull($config['sender_id']);
        $this->assertSame($config['org_id'], $service->getOrgId());
        $this->assertSame($config['sender_id'], $service->getSenderId());
    }

    /** @test */
    public function service_sends_a_message()
    {
        /*** arrange ***/
        $params = new SendHttpApiParams(
            $service = new EngageSpark($this->client),
            $mobile =  $this->faker->phoneNumber,
            $message = $this->faker->sentence
        );

        /*** assert ***/
        $this->client->shouldReceive('request')->once(); //TODO: wait for engagespark api to send response just like topup

        /*** act ***/
        $service->send($params->toArray(), ServiceMode::SMS);
    }

   /** @test */
    public function service_topups_an_amount()
    {
        /*** arrange ***/
        $json = json_encode([
            'phoneNumber' => $mobile = $this->faker->phoneNumber,
            '$maxAmount' => $amount = $this->faker->numberBetween(10,25),
            'amountSent' => $amountSent = $amount,
            '$price' => $price = $amountSent/50,
            'status' => $status = "Success",
            'errorMessage' => $errorMessage = "The value was successfully delivered to the recipient",
            '$clientRef' => $clientRef = Str::random(10),
            '$createdDate' => $createdDate = "2019-05-30 02:09:57"
        ]);
        $mock = new MockHandler([
            new Response(200, [], $json),
        ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $service = new EngageSpark($client);

        /*** act ***/
        $response = $service->send([
            'phoneNumber'     => $mobile,
            'maxAmount'       => (int) $amount,
            'clientRef'       => $clientRef,
        ], ServiceMode::TOPUP);

        /*** assert ***/
        $this->assertEquals(json_decode($json, true), $response);
    }

   // /** @test */
    public function service_actually_sends_a_message()
    {
        /*** arrange ***/
        $params = new SendHttpApiParams(
            $service = app(EngageSpark::class),
            $mobile = '+639173011987',
            $message = 'testing 5'
        );

        /*** act ***/
        $service->send($params->toArray(), ServiceMode::SMS);

        /*** assert ***/
        $this->assertTrue(true);
    }

// /** @test */
    public function service_actually_topups_an_amount()
    {
        /*** arrange ***/
        $params = new TopupHttpApiParams(
            $service = app(EngageSpark::class),
            $mobile = '+639366760473',// '+639166342969',
            $amount = 10,
            $reference = 'EngageSparkTest::service_actually_topups_an_amount'
        );

        /*** act ***/
        $service->send($params->toArray(), ServiceMode::TOPUP);

        /*** assert ***/
        $this->assertTrue(true);
    }
}
