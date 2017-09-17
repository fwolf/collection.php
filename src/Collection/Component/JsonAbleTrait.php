<?php

namespace Fwolf\Common\Collection\Component;

/**
 * Implement of {@link JsonAbleInterface}
 *
 * @property    array $elements
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait JsonAbleTrait
{
    /**
     * Load from json string, will clear present data
     *
     * @param   string $jsonStr
     * @return  $this
     */
    public function fromJson($jsonStr)
    {
        $this->elements = json_decode($jsonStr, true);

        return $this;
    }


    /**
     * Export to json string
     *
     * @param   int $options Options when doing json_encode()
     * @return  array
     */
    public function toJson($options = JSON_UNESCAPED_UNICODE)
    {
        return json_encode($this->elements, $options);
    }
}
