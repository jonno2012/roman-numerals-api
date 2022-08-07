<?php


namespace App\Repositories;


interface NumeralsRepositoryInterface
{
    public const RECENT_DAY_SPAN = 7;
    public const GET_CONVERSION_INCREMENT = 1;
    public const TOP_CONVERSIONS_QUALIFIER = 10;
    public const MOST_RECENT_RESPONSE_LIMIT = 10;
    /**
     * Returns the requested integer conversion. Creates record if doesn't already exist
     *
     * @param int $integer
     * @return array
     */
    public function getConversion(int $integer): array;

    /**
     * Returns an array of the most recently requested conversions
     *
     * @return array
     */
    public function getRecentConversions(): array;

    /**
     * Returns an array of the most requested conversions
     *
     * @param int $limit
     * @return array
     */
    public function getTopConversions(int $limit = self::TOP_CONVERSIONS_QUALIFIER): array;
}
