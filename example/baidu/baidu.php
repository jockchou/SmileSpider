<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

use PageProcessor\PageProcessor;
use Common\Page;
use Pipeline\ConsolePipeline;

class BaiDuPageProcessor implements PageProcessor
{
    public function process(Page &$page)
    {
        $page->putField('statusCode', $page->statusCode);
        $page->putField('url', $page->requestUrl);
        $page->putField('body', mb_substr($page->body, 0, 100));

        if ($page->requestUrl == "http://baidu.com") {
            $page->addTargetRequests(['http://www.sohu.com', 'http://www.oschina.net']);
        }
    }
}

$spider = \Spider\SmileSpider::create(new BaiDuPageProcessor());
$spider->addUrl('http://baidu.com')->addPipeline(new ConsolePipeline())->run();