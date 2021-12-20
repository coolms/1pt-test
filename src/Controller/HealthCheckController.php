<?php


namespace App\Controller;

use App\Service\HealthCheckService;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class HealthCheckController
 */
class HealthCheckController extends AbstractController
{
    private HealthCheckService $healthCheckService;

    /**
     *
     */
    public function __construct(HealthCheckService $healthCheckService)
    {
        $this->healthCheckService = $healthCheckService;
    }

    /**
     * Health check action
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *   summary="Retrieves health status of the application.",
     * )
     * @OA\Response(
     *   response=200,
     *   description="OK",
     *   @OA\JsonContent(
     *       @OA\Property(property="status", type="string", default="ok"),
     *       @OA\Property(property="freeDiscSpace", type="integer"),
     *       @OA\Property(property="memoryUsage", type="integer"),
     *       @OA\Property(property="memoryAllowed", type="integer")
     *   )
     * ),
     * @OA\Tag(name="HealthCheck")
     */
    public function status(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'ok',
            'freeDiscSpace' => $this->healthCheckService->getDiskFreeSpace(),
            'memoryUsage'   => $this->healthCheckService->getMemoryUsage(),
            'memoryAllowed' => $this->healthCheckService->getMemoryUsage(true)
        ]);
    }

    /**
     * Health check action
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *   summary="Retrieves system free disc space.",
     * )
     * @OA\Response(
     *   response=200,
     *   description="OK",
     *   @OA\JsonContent(
     *       @OA\Property(property="freeDiscSpace", type="integer")
     *   )
     * ),
     * @OA\Tag(name="HealthCheck")
     */
    public function discFreeSpace(): JsonResponse
    {
        return new JsonResponse([
            'freeDiscSpace' => $this->healthCheckService->getDiskFreeSpace()
        ]);
    }

    /**
     * Health check action
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *   summary="Retrieves memory usage.",
     * )
     * @OA\Response(
     *   response=200,
     *   description="OK",
     *   @OA\JsonContent(
     *       @OA\Property(property="memoryUsage", type="integer"),
     *       @OA\Property(property="memoryAllowed", type="integer")
     *   )
     * ),
     * @OA\Tag(name="HealthCheck")
     */
    public function memoryUsage(): JsonResponse
    {
        return new JsonResponse([
            'memoryUsage' => $this->healthCheckService->getMemoryUsage(),
            'memoryAllowed' => $this->healthCheckService->getMemoryUsage(true)
        ]);
    }

}
