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

    function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }


}