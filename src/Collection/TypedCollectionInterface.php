<?php

namespace Fwolf\Common\Collection;

use ArrayAccess;
use Countable;
use Fwolf\Common\Collection\Component\ArrayAccessorInterface;
use Fwolf\Common\Collection\Component\ArraySearchInterface;
use Fwolf\Common\Collection\Component\ArraySetComputeInterface;
use Fwolf\Common\Collection\Component\ArraySortInterface;
use Fwolf\Common\Collection\Component\ArrayTravelInterface;
use Fwolf\Common\Collection\Component\JsonAbleInterface;
use Fwolf\Common\Collection\Component\TypedArrayAbleInterface;
use Fwolf\Common\Collection\Component\TypedSpecificInterface;
use Iterator;

/**
 * Collection only allow single object type element
 *
 *
 * - Can only store objects, do not accept scalar or resource, callable type.
 *
 *      - When accept new element, will do type check
 *      - When return collection type, will try to return self, then a new
 *      typed collection instance
 *
 * - Type check and convert may costs, be careful when used on mass data.
 *
 *
 * - Key is also identity of an object, should be unique. It is bind to object
 * instance, and do not change when object property change.
 *
 * - Key need not explicit assign. Child class may implement method to get
 * key/identity from object instance.
 *
 * - Inner elements will always be assoc array, and same when exported.
 *
 *
 * - For method use array parameter, use a typed collection instance also fit.
 *
 *
 * - After PHP 7.0, there are more type hint feature. Single element parameter
 * can use type hint to do type check, but still lack of type check on object
 * array parameter like SomeClass[]. In this case, a typed collection can be
 * declared as type of object array parameter.
 *
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
interface TypedCollectionInterface extends
    ArrayAccess,
    ArrayAccessorInterface,
    ArraySearchInterface,
    ArraySetComputeInterface,
    ArraySortInterface,
    ArrayTravelInterface,
    Countable,
    Iterator,
    JsonAbleInterface,
    TypedArrayAbleInterface,
    TypedSpecificInterface
{
}
