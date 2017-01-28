<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.01.2017
 * Time: 12:35
 */

namespace base;


class Registry implements \ArrayAccess
{
    private $container = array();

    public function offsetSet($key, $value)
    {
        if(!$this->offsetExists($key))
            $this->container[$key] = $value;
        else
            trigger_error('Variable '. $key .' already defined', E_USER_WARNING);
    }

    public function offsetGet($key)
    {
        return $this->container[$key];
    }

    public function offsetExists($key)
    {
        return isset($this->container[$key]);
    }

    public function offsetUnset($key)
    {
        unset($this->container[$key]);
}
}