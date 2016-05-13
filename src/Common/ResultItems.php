<?php
/**
 * Created by PhpStorm.
 * User: jockchou
 * Date: 2016/5/12
 * Time: 19:05
 */

namespace Common;

class ResultItems
{
    private $fields;

    function __construct()
    {
        $this->fields = [];
    }


    public function get($key)
    {
        if (isset($this->fields[$key])) {
            return $this->fields[$key];
        }

        return null;
    }

    public function getAll()
    {
        return $this->fields;

    }

    public function put($key, $value)
    {
        $this->fields[$key] = $value;

        return $this;

    }
}