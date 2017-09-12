<?php

namespace Fwolf\Common\Collection;

use Traversable;

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
}
