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

class EngageSparkTest extends TestCase
{
    /** @var \LBHurtado\EngageSpark\EngageSpark */
    protected $service;

    /** @var HttpClient */
    protected $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = Mockery::mock(Client::class);
        $this->service = new EngageSpark($this->client);
    }

//    /** @test */
    public function service_has_default_public_properties()
    {
        $this->assertSame(config('engagespark.org_id'),    $this->service->getOrgId());
        $this->assertSame(config('engagespark.sender_id'), $this->service->getSenderId());
    }

    /** @test */
    public function it_sends_a_message()
    {
        // Create a mock and queue two responses.
        $mock = new MockHandler([
            new Response(200, [], '{}'),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

// The first request is intercepted with the first response.
        echo $client->request('POST', '/api/sms/relay')->getStatusCode();

//        $this->client->shouldReceive('request')->once();
//
//        $this->service->send([
//            'organization_id' => $this->service->getOrgId(),
//            'mobile_numbers'  => ['639166342969'],
//            'message'         => 'topup soon',
//            'recipient_type'  => 'mobile_number',
//            'sender_id'       => $this->service->getSenderId(),
//        ], 'sms');
    }

//    /** @test */
    public function it_topups_an_amount()
    {
        $mock = new MockHandler([
            new Response(200, [], '{
"phoneNumber": "639166342969",
"maxAmount": "10",
"amountSent": "10",
"price": "0.263",
"status": "Success",
"errorMessage": "The value was successfully delivered to the recipient",
"clientRef": "ABC1234567890",
"createdDate": "2019-05-30 02:09:57"
}'),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $this->service->send([
            'organizationId'  => $this->service->getOrgId(),
            'phoneNumber'     => '639166342969',
            'maxAmount'       => 25,
            'clientRef'       => Str::random(5),
        ], 'topup');
    }
}
