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

function handleMessage($msgQueue, $message, $index)
{
    sleep(rand(1, 3));
    echo "handle message: " . $message . ", current p: $index\n";

    if ($index === 0) {
        for ($i = 1; $i <= 2; $i++) {
            $msgQueue->push($message . "-->" . $i);
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