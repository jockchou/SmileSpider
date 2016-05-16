<?php
/**
 * Created by PhpStorm.
 * User: jockchou
 * Date: 2016/5/12
 * Time: 19:11
 */

namespace Scheduler;

interface Scheduler
{
    public function push($request);

    public function poll();

    public function count();
}