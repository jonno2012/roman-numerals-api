<?php


namespace App\Repositories;

use App\Models\Conversion;
use App\Services\RomanNumeralConverter;
use Illuminate\Support\Carbon;

/**
 * Class EloquentNumeralsRepository
 * @package App\Repositories
 */
class EloquentNumeralsRepository implements NumeralsRepositoryInterface
{
    /**
     * @var RomanNumeralConverter
     */
    private RomanNumeralConverter $converter;

    /**
     * EloquentNumeralsRepository constructor.
     * @param RomanNumeralConverter $converter
     */
    public function __construct(RomanNumeralConverter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * Returns the requested integer conversion. Creates record if doesn't already exist
     *
     * @param int $integer
     * @return array
     */
    public function getConversion(int $integer): array
    {
        $conversion = Conversion::firstOrCreate(
            ['integer' => $integer],
            ['numeral' => $this->converter->convertInteger($integer)]
        );

        $conversion->update(['count' => $conversion->count + self::GET_CONVERSION_INCREMENT]);
        return $conversion->toArray();
    }

    /**
     * Returns an array of the most recently requested conversions
     *
     * @return array
     */
    public function getRecentConversions(): array
    {
        $start = Carbon::now()->subDays(self::RECENT_DAY_SPAN);
        $end = Carbon::now()->toDateTimeString();

        return Conversion::query()
            ->where('updated_at', '>', $start)
            ->where('updated_at', '<=', $end)
            ->orderBy('updated_at', 'DESC')
            ->limit(self::MOST_RECENT_RESPONSE_LIMIT)
            ->get()->toArray();
    }

    /**
     * Returns an array of the most requested conversions
     *
     * @param int $limit
     * @return array
     */
    public function getTopConversions(int $limit = self::TOP_CONVERSIONS_QUALIFIER): array
    {
        return Conversion::query()->orderBy('count', 'DESC')->limit($limit)->get()->toArray();
    }
}
