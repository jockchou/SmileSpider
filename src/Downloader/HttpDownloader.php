<?php
/**
 * Created by PhpStorm.
 * User: jockchou
 * Date: 2016/5/12
 * Time: 19:53
 */

namespace Downloader;

use Common\Page;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class HttpDownloader implements Downloader
{
    private $client;
    private $timeout;

    function __construct()
    {
        $this->client = new Client();
        $this->timeout = 2;
    }

    /**
     * @param Request $request
     * @return Page
     */
    public function download(Request $request)
    {
        $response = $this->client->send($request, $this->timeout);

        return new Page($request, $response);
    }
}