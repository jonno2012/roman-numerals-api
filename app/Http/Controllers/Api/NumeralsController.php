<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ConvertRequest;
use App\Repositories\NumeralsRepositoryInterface;
use App\Transformers\ConversionTransformer;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * Class NumeralsController
 * @package App\Http\Controllers\Api
 */
class NumeralsController extends Controller
{
    /**
     * @var NumeralsRepositoryInterface
     */
    private NumeralsRepositoryInterface  $numeralsRepository;
    /**
     * @var ConversionTransformer
     */
    private ConversionTransformer $conversionTransformer;

    /**
     * NumeralsController constructor.
     * @param NumeralsRepositoryInterface $numeralsRepository
     * @param ConversionTransformer $conversionTransformer
     */
    public function __construct(NumeralsRepositoryInterface $numeralsRepository, ConversionTransformer $conversionTransformer)
    {
        $this->numeralsRepository = $numeralsRepository;
        $this->conversionTransformer = $conversionTransformer;
    }

    /**
     * Returns integer conversion and creates if not in DB already
     *
     * @param ConvertRequest $request
     * @return JsonResponse
     */
    public function convert(ConvertRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $conversion = $this->numeralsRepository->getConversion($validated['integer']);
        $status = $conversion['count'] > 1 ? HttpResponse::HTTP_OK : HttpResponse::HTTP_CREATED;

        return $this->respondWithItem($conversion, $this->conversionTransformer, true, $status);
    }

    /**
     * Returns the most recent conversions
     *
     * @return JsonResponse
     */
    public function recentlyConverted(): JsonResponse
    {
        $recentlyConverted = $this->numeralsRepository->getRecentConversions();

        return $this->respondWithCollection($recentlyConverted, $this->conversionTransformer, true, HTTPResponse::HTTP_OK);
    }

    /**
     * Returns ten most frequently requested conversions
     *
     * @return JsonResponse
     */
    public function topTen(): JsonResponse
    {
        $topConversions = $this->numeralsRepository->getTopConversions();

        return $this->respondWithCollection($topConversions, $this->conversionTransformer, true, HTTPResponse::HTTP_OK);
    }
}
