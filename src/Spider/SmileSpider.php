<?php
/**
 * Created by PhpStorm.
 * User: jockchou
 * Date: 2016/5/12
 * Time: 19:35
 */

namespace Spider;

use Downloader\Downloader;
use Downloader\HttpDownloader;
use GuzzleHttp\Psr7\Request;
use PageProcessor\PageProcessor;
use Scheduler\QueueScheduler;
use Pipeline\Pipeline;
use Common\Page;

class SmileSpider
{
    protected $downloader;
    protected $pageProcessor;
    protected $scheduler;
    protected $pipelines;

    function __construct(PageProcessor $processor)
    {
        $this->downloader = new HttpDownloader();
        $this->pageProcessor = $processor;
        $this->scheduler = new QueueScheduler();
        $this->pipelines = [];
    }

    public static function create(PageProcessor $processor)
    {
        return new SmileSpider($processor);
    }

    public function addUrl($url)
    {

        $this->scheduler->push(new Request('GET', $url));

        return $this;
    }

    public function addPipeline(Pipeline $pipeline)
    {
        $this->pipelines[] = $pipeline;

        return $this;
    }

    public function run()
    {
        while ($this->scheduler->count() > 0) {
            //从队列里取一个链接
            $request = $this->scheduler->poll();

            //下载页面
            $page = $this->downloader->download($request);

            if ($page !== null) {
                //处理页面
                $this->pageProcessor->process($page);

                //抽取以上页面中新增的额外链接
                $this->extractRequests($page);

                //处理从页面中获取的结果
                $this->extractResultItems($page);
            }
        }
    }

    //添加额外的请求
    protected function extractRequests(Page $page)
    {
        foreach ($page->targetRequests as $request) {
            $this->scheduler->push($request);
        }
    }

    //处理从页面中获取的结果
    protected function extractResultItems(Page $page)
    {
        foreach ($this->pipelines as $pipeline) {
            $pipeline->process($page->resultItems, $this);
        }
    }

}