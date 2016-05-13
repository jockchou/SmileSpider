<?php
/**
 * Created by PhpStorm.
 * User: jockchou
 * Date: 2016/5/13
 * Time: 10:04
 */

namespace Pipeline;

use Common\ResultItems;

class ConsolePipeline implements Pipeline
{
    /**
     * @param ResultItems $resultItems
     */
    public function process(ResultItems $resultItems)
    {
        foreach ($resultItems->getAll() as $key => $value) {
            printf("%10s:\t%s\n", $key, $value);
        }
    }
}