<?php

namespace Fwolf\Common\Collection;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class Collection implements CollectionInterface
{
    use CollectionTrait;


    /**
     * Real elements in collection
     *
     * @var array
     */
    protected $elements = [];


    /**
     * Constructor
     *
     * @param   array $elements
     */
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }
}
