<?php
/**
 * Created by PhpStorm.
 * User: jockchou
 * Date: 2016/5/16
 * Time: 10:05
 */

namespace Scheduler;

use Ko\Semaphore;
use GuzzleHttp\Psr7\Request;

class MessageQueueScheduler implements Scheduler
{
    private $queue;
    private $key;
    private $locker;

    const MSG_TYPE = 1;
    const MAX_SIZE = 2048;

    function __construct()
    {
        $this->key = ftok(__FILE__, 'G');
        $this->locker = new Semaphore();
        if ($this->key === -1) {
            throw new \Exception("Failed to ftok");
        }
        $this->queue = msg_get_queue($this->key);
    }

    public function push($request)
    {
        $this->locker->acquire();
        $result = msg_send($this->queue, self::MSG_TYPE, $request, false, false);
        $this->locker->release();

        return $result;
    }

    public function poll()
    {
        //$this->locker->acquire();
        msg_receive($this->queue, 0, $msgType, self::MAX_SIZE, $message, false, MSG_IPC_NOWAIT);

        //$this->locker->release();

        return $message;
    }

    public function count()
    {
        $this->locker->acquire();
        $msgStat = msg_stat_queue($this->queue);
        $this->locker->release();

        return $msgStat['msg_qnum'];
    }
}