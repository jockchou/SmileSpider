<?php
/**
 * Created by PhpStorm.
 * User: jockchou
 * Date: 2016/5/12
 * Time: 19:02
 */

namespace Pipleline;

use \Common\ResultItems;
use \Common\Task;

interface Pipleline
{
    public function process(ResultItems $resultItems, Task $task);
}