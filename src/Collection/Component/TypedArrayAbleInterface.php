<?php

namespace Fwolf\Common\Collection\Component;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
interface TypedArrayAbleInterface extends ArrayAbleInterface
{
    /**
     * Load from PHP array, will clear present data
     *
     * @param   object[] $objects Array of allowed object
     * @return  $this
     */
    public function fromArray(array $objects);


    /**
     * To native PHP array of allowed object
     *
     * @return  object[]
     */
    public function toArray();
}
