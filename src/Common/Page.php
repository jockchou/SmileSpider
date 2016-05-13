<?php
/**
 * Created by PhpStorm.
 * User: jockchou
 * Date: 2016/5/12
 * Time: 19:03
 */

namespace Common;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class Page
{
    public $request;
    public $response;

    public $targetRequests;
    public $resultItems;

    public $body;
    public $requestUrl;
    public $requestMethod;
    public $statusCode;
    public $reasonPhrase;

    function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;

        $this->init();
    }

    private function init()
    {
        $this->targetRequests = [];
        $this->resultItems = new ResultItems();

        $this->statusCode = $this->response->getStatusCode();
        $this->reasonPhrase = $this->response->getReasonPhrase();

        $this->body = (string)$this->response->getBody();
        $this->requestUrl = (string)$this->request->getUri();
        $this->requestMethod = $this->request->getMethod();
    }

    public function addTargetRequest($url)
    {
        $this->targetRequests[] = new Request('GET', $url);
    }

    public function addTargetRequests(array $urlList)
    {
        foreach ($urlList as $url) {
            $this->addTargetRequest($url);
        }
    }
}