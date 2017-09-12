<?php

namespace Fwolf\Common\Collection\Component;

use ArrayIterator;
use Iterator;
use Traversable;

/**
 * Implement of IteratorAggregate interface
 *
 * @link        http://php.net/manual/en/class.iteratoraggregate.php
 *
 * @property    array $elements
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait IteratorAggregateTrait
{
    /**
     * Retrieve an external iterator
     *
     * @link    http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return  Traversable | Iterator
     */
    public function getIterator()
    {
        return (new ArrayIterator($this->elements));
    }
}
