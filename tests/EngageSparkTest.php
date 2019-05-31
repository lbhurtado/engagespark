<?php

namespace LBHurtado\EngageSpark\Tests;

use Mockery;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use LBHurtado\EngageSpark\EngageSpark;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;


use LBHurtado\EngageSpark\Classes\SendHttpApiParams;

class EngageSparkTest extends TestCase
{
    /** @var HttpClient */
    protected $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = Mockery::mock(Client::class);
        // $this->service = new EngageSpark($this->client);
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
            $mobile_number = '+639173011987', 
            $message = 'The quick brown fox jumps over the lazy dog - again.', 
            $sender_id = 'TXTCMDR'
        );

        //TODO: wait for engagespark api to send response just like topup
        /*** assert ***/
        $this->client->shouldReceive('request')->once();

        /*** act ***/
        $service->send($params->toArray(), 'sms');
    }

   /** @test */
    public function it_topups_an_amount()
    {
        /*** arrange ***/
        $phoneNumber = '+639171234567';
        $maxAmount = '10';
        $amountSent = '10';
        $price = "0.263";
        $status = "Success";
        $errorMessage = "The value was successfully delivered to the recipient";
        $clientRef = "ABC1234567890";
        $createdDate = "2019-05-30 02:09:57";

        $json = json_encode(compact('phoneNumber', 'maxAmount', 'amountSent', 'price', 'status', 'errorMessage', 'clientRef', 'createdDate'));

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
