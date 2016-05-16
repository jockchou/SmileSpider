<?php
/**
 * Created by PhpStorm.
 * User: jockchou
 * Date: 2016/5/12
 * Time: 20:13
 */

namespace Scheduler;

class QueueScheduler implements Scheduler
{
    private $queue;

    function __construct()
    {
        $this->queue = new \SplQueue();
    }

    public function push($request)
    {
        //去重判断
        $this->queue->push($request);
    }

    public function poll()
    {
        return $this->queue->shift();

    }

    public function count()
    {
        return $this->queue->count();
    }
}