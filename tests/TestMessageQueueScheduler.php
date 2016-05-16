<?php

/**
 * Created by PhpStorm.
 * User: jockchou
 * Date: 2016/5/16
 * Time: 11:00
 */

require_once(__DIR__ . '/../vendor/autoload.php');

use Scheduler\MessageQueueScheduler;

$msgQueue = new MessageQueueScheduler();

$msgQueue->push("0");

function handleMessage($msgQueue, $message, $p)
{
    echo "handle message: " . $message . ", current p: $p\n";

    if ($message === "0") {
        for ($i = 1; $i <= 5; $i++) {
            $msgQueue->push($i);
        }
    }
}

$fork = new \Common\Fork;

for ($i = 0; $i < 5; $i++) {
    $fork->call(function () use ($msgQueue, $i) {
        while ($msgQueue->count() > 0) {
            handleMessage($msgQueue, $msgQueue->poll(), $i);
        }
    });
}

$fork->wait();