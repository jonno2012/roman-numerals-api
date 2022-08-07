<?php

namespace App\Services;

/**
 * Interface IntegerConverterInterface
 * @package App\Services
 */
interface IntegerConverterInterface
{
    /**
     * @param int $integer
     * @return string
     */
    public function convertInteger(int $integer): string;
}
