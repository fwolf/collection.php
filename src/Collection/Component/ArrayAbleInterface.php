<?php

namespace Fwolf\Common\Collection\Component;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
interface ArrayAbleInterface
{
    /**
     * Load from PHP array, will clear present data
     *
     * @param   array $arrayData
     * @return  $this
     */
    public function fromArray(array $arrayData);


    /**
     * To native PHP array
     *
     * @return  array
     */
    public function toArray();
}
