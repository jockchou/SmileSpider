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

for ($i = 0; $i < 25; $i++) {
    //创建子进程
    $pid = pcntl_fork();

    if ($pid) {
        echo "No.$i child process was created, the pid is $pid\n";
    } elseif ($pid == 0) {
        while ($msgQueue->count() > 0) {
            //从队列里取一个
            $message = $msgQueue->poll();

            //处理消息
            handleMessage($message);
        }
    }
}