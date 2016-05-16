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

$pids = array();

for ($i = 0; $i < 5; $i++) {
    //创建子进程
    $pids[$i] = pcntl_fork();

    if ($pids[$i]) {
        echo "No.$i child process was created, the pid is $pids[$i]\r\n";
    } elseif ($pids[$i] == 0) {
        $pid = posix_getpid();

        echo "process.$pid is writing now\r\n";

        $msgQueue->push("data-" . $i);

        posix_kill($pid, SIGTERM);
    }
}

do {

    $message = $msgQueue->poll();

    echo $message . "\n";

    
    //需要判断队列是否为空，如果为空就退出
    if ($msgQueue->count() <= 0) {
        break;
    }
} while (true);