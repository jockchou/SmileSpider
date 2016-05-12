<?php
/**
 * Created by PhpStorm.
 * User: jockchou
 * Date: 2016/5/12
 * Time: 19:16
 */

namespace PageProcessor;

use \Common\Page;

interface PageProcessor
{
    public function process(Page &$page);
}