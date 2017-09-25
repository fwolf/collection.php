<?php

namespace Fwolf\Common\Collection;

use Fwolf\Common\Collection\Component\ArrayAccessorTrait;
use Fwolf\Common\Collection\Component\ArrayAccessTrait;
use Fwolf\Common\Collection\Component\ArraySearchTrait;
use Fwolf\Common\Collection\Component\ArraySetComputeTrait;
use Fwolf\Common\Collection\Component\ArraySortTrait;
use Fwolf\Common\Collection\Component\ArrayTravelTrait;
use Fwolf\Common\Collection\Component\CountableTrait;
use Fwolf\Common\Collection\Component\IteratorTrait;
use Fwolf\Common\Collection\Component\JsonAbleTrait;
use Fwolf\Common\Collection\Component\TypedArrayAbleTrait;
use Fwolf\Common\Collection\Component\TypedSpecificTrait;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait TypedCollectionTrait
{
    use ArrayAccessTrait;
    use ArrayAccessorTrait;
    use ArraySearchTrait;
    use ArraySetComputeTrait;
    use ArraySortTrait;
    use ArrayTravelTrait;
    use CountableTrait;
    use IteratorTrait;
    use JsonAbleTrait;
    use TypedArrayAbleTrait;
    use TypedSpecificTrait;
}
