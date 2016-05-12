<?php
/**
 * Created by PhpStorm.
 * User: jockchou
 * Date: 2016/5/12
 * Time: 19:11
 */

namespace Scheduler;

use \GuzzleHttp\Psr7\Request;

interface Scheduler
{
    public function push(Request $request);

    public function poll();

    public function count();
}