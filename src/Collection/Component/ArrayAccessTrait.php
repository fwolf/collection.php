<?php

namespace Fwolf\Common\Collection\Component;

/**
 * Implement of ArrayAccess interface
 *
 * @link        http://php.net/manual/en/class.arrayaccess.php
 *
 * @property    array $elements
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait ArrayAccessTrait
{
    /**
     * Whether a offset exists
     *
     * @link    http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param   mixed $offset
     * @return  bool    True on success or false on failure.
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->elements);
    }


    /**
     * Offset to retrieve
     *
     * @link    http://php.net/manual/en/arrayaccess.offsetget.php
     * @param   mixed $offset
     * @return  mixed
     */
    public function offsetGet($offset)
    {
        return $this->elements[$offset];
    }


    /**
     * Offset to set
     *
     * @link    http://php.net/manual/en/arrayaccess.offsetset.php
     * @param   mixed $offset
     * @param   mixed $value
     * @return  void
     */
    public function offsetSet($offset, $value)
    {
        $this->elements[$offset] = $value;
    }


    /**
     * Offset to unset
     *
     * @link    http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param   mixed $offset
     * @return  void
     */
    public function offsetUnset($offset)
    {
        unset($this->elements[$offset]);
    }
}
