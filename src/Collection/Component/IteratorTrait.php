<?php

namespace Fwolf\Common\Collection\Component;

/**
 * Implement of Iterator interface
 *
 * @link        http://php.net/manual/en/class.iterator.php
 *
 * @property    array $elements
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait IteratorTrait
{
    /**
     * Return the current element
     *
     * @link    http://php.net/manual/en/iterator.current.php
     * @return  mixed
     */
    public function current()
    {
        return current($this->elements);
    }


    /**
     * Return the key of the current element
     *
     * @link    http://php.net/manual/en/iterator.key.php
     * @return  mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return key($this->elements);
    }


    /**
     * Move forward to next element
     *
     * @link    http://php.net/manual/en/iterator.next.php
     * @return  void Any returned value is ignored.
     */
    public function next()
    {
        next($this->elements);
    }


    /**
     * Rewind the Iterator to the first element
     *
     * @link    http://php.net/manual/en/iterator.rewind.php
     * @return  void Any returned value is ignored.
     */
    public function rewind()
    {
        reset($this->elements);
    }


    /**
     * Checks if current position is valid
     *
     * @link    http://php.net/manual/en/iterator.valid.php
     * @return  bool    The return value will be casted to boolean and then
     *                  evaluated. Returns true on success or false on failure.
     */
    public function valid()
    {
        return false !== $this->current();
    }
}
