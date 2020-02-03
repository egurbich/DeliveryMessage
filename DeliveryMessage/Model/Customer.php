<?php

namespace Magecom\DeliveryMessage\Model;

/**
 * Class Message
 * @package Magecom\DeliveryMessage\Model\Delivery
 */
class Customer
{
    const DIGITS_LIMIT = 5;

    /**
     * Logic for getting customer Zip Code
     *
     * @return int
     */
    public function zipCode()
    {
        return rand(pow(10, self::DIGITS_LIMIT-1), pow(10, self::DIGITS_LIMIT)-1);
    }
}
