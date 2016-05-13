<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

use \PageProcessor\PageProcessor;
use \Common\Page;
use \Pipeline\ConsolePipeline;

class BaiDuPageProcessor implements PageProcessor
{
    public function process(Page &$page)
    {
        $page->resultItems->put('statusCode', $page->statusCode);
        $page->resultItems->put('url', $page->requestUrl);
        $page->resultItems->put('body', mb_substr($page->body, 0, 20));

        if ($page->requestUrl == "http://baidu.com") {
            $page->addTargetRequests(['http://www.sohu.com', 'http://www.oschina.net']);
        }
    }
}

$spider = \Spider\SmileSpider::create(new BaiDuPageProcessor());
$spider->addUrl('http://baidu.com')->addPipeline(new ConsolePipeline())->run();