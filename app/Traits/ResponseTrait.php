<?php


namespace App\Traits;

use Illuminate\Http\JsonResponse;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

/**
 * Trait ResponseTrait
 * @package App\Traits
 */
trait ResponseTrait
{
    /**
     * @var Manager
     */
    public Manager $fractal;

    /**
     * Returns a Fractal collection response
     *
     * @param array $collection
     * @param $callback
     * @param bool $success
     * @param int $status
     *  @return JsonResponse
     */
    public function respondWithCollection(array $collection, $callback, bool $success, int $status): JsonResponse
    {
        $this->fractal = new Manager();

        $resources = new Collection($collection, $callback);

        if(empty($collection)) {
            $resources = new Collection($collection, $callback);
        }

        $rootScope = $this->fractal->createData($resources);

        return $this->responseJson($success, $status, [], $rootScope->toArray());
    }

    /**
     * Returns a single item using fractal
     *
     * @param $item
     * @param $callback
     * @param bool $success
     * @param int $status
     * @return JsonResponse
     */
    public function respondWithItem($item, $callback, bool $success, int $status): JsonResponse
    {
        $this->fractal = new Manager();

        $resource = new Item($item, $callback);
        $rootScope = $this->fractal->createData($resource);

        return $this->responseJson($success, $status, [], $rootScope->toArray());
    }

    /**
     * Returns custom json response
     *
     * @param bool $success
     * @param int $status
     * @param array $error
     * @param array $data
     * @return JsonResponse
     */
    public function responseJson(bool $success, int $status, array $error = [], array $data = []): JsonResponse
    {
        $result_data = !empty($data) ? isset($data['data']) ? $data : ['data' => $data] : [];

        return response()->json(array_merge([
            'success' => $success,
            'status' => $status,
            'error' => $error,
        ], $result_data), $status);
    }
}
