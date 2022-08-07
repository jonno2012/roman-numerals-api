<?php

namespace App\Services;

use Machinateur\RomanNumerals\Convert;

/**
 * Class RomanNumeralConverter
 * @package App\Services
 */
class RomanNumeralConverter
{
    /**
     * @param int $integer
     * @return string
     */
    public function convertInteger(int $integer): string
    {
        return Convert::toRomanNumeral($integer);
    }
}
