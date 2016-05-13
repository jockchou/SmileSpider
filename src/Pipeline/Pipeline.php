<?php
/**
 * Created by PhpStorm.
 * User: jockchou
 * Date: 2016/5/12
 * Time: 19:02
 */

namespace Pipeline;

use \Common\ResultItems;

interface Pipeline
{
    public function process(ResultItems $resultItems);
}