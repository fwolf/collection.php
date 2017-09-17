<?php

namespace Fwolf\Common\Collection\Component;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
interface JsonAbleInterface
{
    /**
     * Load from json string, will clear present data
     *
     * @param   string $jsonStr
     * @return  $this
     */
    public function fromJson($jsonStr);


    /**
     * Export to json string
     *
     * @param   int $options Options when doing json_encode()
     * @return  array
     */
    public function toJson($options = JSON_UNESCAPED_UNICODE);
}
