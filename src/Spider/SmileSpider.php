<?php
/**
 * Created by PhpStorm.
 * User: jockchou
 * Date: 2016/5/12
 * Time: 19:35
 */

namespace Spider;

use Common\Task;
use Downloader\Downloader;
use PageProcessor\PageProcessor;

class SmileSpider implements Task
{
    protected $downloader;
    protected $pageProcessor;
    protected $scheduler;
    protected $pipelines;

    public function getTaskId()
    {
        // TODO: Implement getTaskId() method.
    }

    public static function create(PageProcessor $processor)
    {
        return new SmileSpider();
    }

    public function addUrl($url)
    {

        return $this;
    }

    public function run()
    {
        while ($this->scheduler->count() > 0) {
            $request = $this->scheduler->poll();
            $page = $this->downloader->download($request);
            $this->pageProcessor->process($page);
            $this->extractRequests($page);
        }
    }

    //添加额外的请求
    protected function extractRequests(Page $page)
    {
        foreach ($page->targetRequests as $request) {
            $this->scheduler->push($request);
        }
    }

    protected function extractResultItems(Page $page)
    {
        foreach ($this->pipelines as $pipeline) {

        }

    }

}