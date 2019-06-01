<?php

namespace LBHurtado\EngageSpark;

use Illuminate\Support\Arr;
use GuzzleHttp\Client as HttpClient;
use LBHurtado\EngageSpark\Classes\ServiceMode;

class EngageSpark
{
    /** @var HttpClient */
    protected $client;

    /** @var array */
    protected $end_points;

    /** @var string */
    protected $api_key;

    /** @var string */
    protected $org_id;

    /** @var string */
    protected $sender_id;

    /**
     * EngageSpark constructor.
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
        $this->initializeProperties();
    }

    /**
     * Set protected and public properties.
     */
    protected function initializeProperties(): void
    {
        tap(config('engagespark'), function($config) {
            $this->end_points = Arr::get($config, 'end_points');
            $this->api_key    = Arr::get($config, 'api_key');
            $this->org_id     = Arr::get($config, 'org_id');
            $this->sender_id  = Arr::get($config, 'sender_id');
        });
    }

    /**
     * @param $params
     * @param string $mode
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send($params, $mode = ServiceMode::SMS)
    {
        $endPoint = $this->getEndPoint($mode);
        $request = $this->getFormattedRequestHeadersAndJsonData($params);

        return optional($this->client->request('POST', $endPoint, $request), function ($response) {
            return $this->getFormattedResponse($response);
        });
    }

    /**
     * @return string
     */
    public function getOrgId()
    {
        return $this->org_id;
    }

    /**
     * @return string
     */
    public function getSenderId()
    {
        return $this->sender_id;
    }

    /**
     * @param $mode
     * @return mixed
     */
    public function getEndPoint($mode)
    {
        return Arr::get($this->end_points, $mode, $this->end_points['sms']);
    }

    /**
     * @return string
     */
    protected function getApiKey()
    {
        return $this->api_key;
    }

    /**
     * @return array
     */
    protected function getHeaders()
    {
        return [
            'Authorization' => "Token {$this->getApiKey()}",
            'Accept' => 'application/json',
        ];
    }

    /**
     * There may be base parameters in the future. Just putting it here.
     *
     * @param array $params
     * @return array
     */
    protected function consolidateParams(array $params)
    {
        $base = [];

        return \array_merge($base, \array_filter($params));
    }

    /**
     * @param $params
     * @return array
     */
    protected function getFormattedRequestHeadersAndJsonData($params): array
    {
        return [
            'headers' => $this->getHeaders(),
            'json' => $this->consolidateParams($params)
        ];
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function getFormattedResponse(\Psr\Http\Message\ResponseInterface $response)
    {
        $response = \json_decode((string)$response->getBody(), true);
        return $response;
    }
}
