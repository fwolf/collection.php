<?php

namespace Fwolf\Common\Collection;

use Fwolf\Common\Collection\Component\ArrayAbleTrait;
use Fwolf\Common\Collection\Component\ArrayAccessTrait;
use Fwolf\Common\Collection\Component\CountableTrait;
use Fwolf\Common\Collection\Component\IteratorTrait;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait CollectionTrait
{
    use ArrayAbleTrait;
    use ArrayAccessTrait;
    use CountableTrait;
    use IteratorTrait;
}
