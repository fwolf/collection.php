<?php

namespace Fwolf\Common\Collection\Component;

/**
 * Implement of Countable interface
 *
 * @link        http://php.net/manual/en/class.countable.php
 *
 * @property    array $elements
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait CountableTrait
{
    /**
     * Count elements of an object
     *
     * @link    http://php.net/manual/en/countable.count.php
     * @return  int
     */
    public function count()
    {
        return count($this->elements);
    }
}
