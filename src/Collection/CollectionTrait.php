<?php

namespace Fwolf\Common\Collection;

use Fwolf\Common\Collection\Component\ArrayAccessTrait;
use Fwolf\Common\Collection\Component\CountableTrait;
use Fwolf\Common\Collection\Component\IteratorAggregateTrait;
use Fwolf\Common\Collection\Component\IteratorTrait;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait CollectionTrait
{
    use ArrayAccessTrait;
    use CountableTrait;
    use IteratorTrait;
    use IteratorAggregateTrait;
}
