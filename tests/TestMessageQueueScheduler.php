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

function handleMessage($message)
{
    sleep(rand(1, 3));
    echo "handle message: " . $message . "\n";

    for ($i = 0; $i < 3; $i++) {
        $msgQueue->push($message . "-->" . $i);
    }
}

$fork = new \duncan3dc\Helpers\Fork;

for ($i = 0; $i < 5; $i++) {
    $fork->call(function () use ($msgQueue) {
        while ($msgQueue->count() > 0) {
            handleMessage($msgQueue->poll());
        }
    });
}

$fork->wait();