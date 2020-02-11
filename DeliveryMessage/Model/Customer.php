<?php

declare(strict_types=1);

namespace Magecom\DeliveryMessage\Model;

/**
 * Class Message
 */
class Customer
{
    const DIGITS_LIMIT = 5;

    /**
     * Logic for getting customer Zip Code
     * Here is an emulation of getting customer's Zip Code.
     * This can be replaced with real logic of getting customer Zip Code (for production purposes).
     *
     * @return int
     */
    public function zipCode() : int
    {
        return rand(pow(10, self::DIGITS_LIMIT-1), pow(10, self::DIGITS_LIMIT)-1);
    }
}
