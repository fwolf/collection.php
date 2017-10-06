<?php

namespace Fwolf\Common\Collection;

use Fwolf\Common\Collection\Component\ArraySortTrait;
use Fwolf\Common\Collection\Component\ArrayTravelTrait;
use Fwolf\Common\Collection\Component\CountableTrait;
use Fwolf\Common\Collection\Component\IteratorTrait;
use Fwolf\Common\Collection\Component\JsonAbleTrait;
use Fwolf\Common\Collection\Component\TypedArrayAbleTrait;
use Fwolf\Common\Collection\Component\TypedArrayAccessorTrait;
use Fwolf\Common\Collection\Component\TypedArrayAccessTrait;
use Fwolf\Common\Collection\Component\TypedArraySearchTrait;
use Fwolf\Common\Collection\Component\TypedArraySetComputeTrait;
use Fwolf\Common\Collection\Component\TypedSpecificTrait;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait TypedCollectionTrait
{
    use ArraySortTrait;
    use ArrayTravelTrait;
    use CountableTrait;
    use IteratorTrait;
    use JsonAbleTrait;
    use TypedArrayAbleTrait;
    use TypedArrayAccessTrait;
    use TypedArrayAccessorTrait;
    use TypedArraySearchTrait;
    use TypedArraySetComputeTrait;
    use TypedSpecificTrait;
}
