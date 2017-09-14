<?php

namespace FwolfTest\Common\Collection\Component;

use Fwolf\Common\Collection\Component\ArrayAccessorTrait;
use Fwolf\Common\Collection\Component\CountableTrait;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class ArrayAccessorTraitTestDummy
{
    use ArrayAccessorTrait;
    use CountableTrait;


    /**
     * @var array $elements
     */
    protected $elements;


    /**
     * @param   array $elements
     */
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }
}
