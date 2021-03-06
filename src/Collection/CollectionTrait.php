<?php

namespace Fwolf\Common\Collection;

use Fwolf\Common\Collection\Component\ArrayAbleTrait;
use Fwolf\Common\Collection\Component\ArrayAccessorTrait;
use Fwolf\Common\Collection\Component\ArrayAccessTrait;
use Fwolf\Common\Collection\Component\ArraySearchTrait;
use Fwolf\Common\Collection\Component\ArraySetComputeTrait;
use Fwolf\Common\Collection\Component\ArraySortTrait;
use Fwolf\Common\Collection\Component\ArrayTravelTrait;
use Fwolf\Common\Collection\Component\CountableTrait;
use Fwolf\Common\Collection\Component\IteratorTrait;
use Fwolf\Common\Collection\Component\JsonAbleTrait;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait CollectionTrait
{
    use ArrayAbleTrait;
    use ArrayAccessTrait;
    use ArrayAccessorTrait;
    use ArraySearchTrait;
    use ArraySetComputeTrait;
    use ArraySortTrait;
    use ArrayTravelTrait;
    use CountableTrait;
    use IteratorTrait;
    use JsonAbleTrait;
}
