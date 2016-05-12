<?php
/**
 * Created by PhpStorm.
 * User: jockchou
 * Date: 2016/5/12
 * Time: 18:57
 */

namespace Downloader;

use \GuzzleHttp\Psr7\Request;

interface Downloader
{
    /**
     * @param Request $request
     * @return Page
     */
    public function download(Request $request);
}