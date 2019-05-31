<?php

namespace LBHurtado\EngageSpark\Tests;

use Mockery;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

use LBHurtado\EngageSpark\EngageSpark;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

use LBHurtado\EngageSpark\Classes\SendHttpApiParams;
use LBHurtado\EngageSpark\Classes\TopupHttpApiParams;
use Illuminate\Foundation\Testing\WithFaker;

class EngageSparkTest extends TestCase
{
    use WithFaker;

    /** @var HttpClient */
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
    public function it_sends_a_message()
    {
        /*** arrange ***/
        $service = new EngageSpark($this->client);
        $params = new SendHttpApiParams(
            $org_id = $service->getOrgId(), 
            $mobile_number =  $this->faker->phoneNumber,
            $message = $this->faker->sentence,
            $sender_id = $this->faker->word
        );

        /*** assert ***/
        $this->client->shouldReceive('request')->once(); //TODO: wait for engagespark api to send response just like topup

        /*** act ***/
        $service->send($params->toArray(), 'sms');
    }

   /** @test */
    public function it_topups_an_amount()
    {
        /*** arrange ***/
        $json = json_encode([
            'phoneNumber' => $phoneNumber = $this->faker->phoneNumber,
            '$maxAmount' => $maxAmount = $this->faker->numberBetween(10,25),
            'amountSent' => $amountSent = $maxAmount,
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
            'organizationId'  => $service->getOrgId(),
            'phoneNumber'     => $phoneNumber,
            'maxAmount'       => (int) $maxAmount,
            'clientRef'       => $clientRef,
        ], 'topup');

        /*** assert ***/
        $this->assertEquals(json_decode($json, true), $response);
    }
}
