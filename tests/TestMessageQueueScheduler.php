<?php

/**
 * Created by PhpStorm.
 * User: jockchou
 * Date: 2016/5/16
 * Time: 11:00
 */

require_once(__DIR__ . '/../vendor/autoload.php');

use Scheduler\MessageQueueScheduler;
use Ko\Semaphore;

const EMPTY_WAIT_TIME = 30;

$msgQueue = new MessageQueueScheduler();
$locker = new Semaphore();

$msgQueue->push("0");


function handleMessage($msgQueue, $message)
{
    $pid = posix_getpid();

    echo "handle message: " . $message . ", current p: $pid\n";

    sleep(1);
    if ($message === "0") {
        for ($i = 1; $i <= 100; $i++) {
            $msgQueue->push($i);
        }
    }

    if ($message === "100") {
        for ($i = 101; $i <= 200; $i++) {
            $msgQueue->push($i);
        }
    }
}

$fork = new \Common\Fork;

for ($i = 0; $i < 5; $i++) {
    $fork->call(function () use ($msgQueue) {
        while (true) {
            $message = null;
            $locker->acquire();
            if ($msgQueue->count() > 0) {
                $message = $msgQueue->poll();
                $locker->release();
            } else {
                $locker->release();
                break;
            }
            if ($message) {
                handleMessage($msgQueue, $message);
            }
        }

        $pid = posix_getpid();
        echo "process: $pid end!\n";
    });
}

$fork->wait();