<?php


namespace App\Controller;

use App\DTO\Request\CriteriaDTO;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractController extends SymfonyAbstractController
{

    protected const PROP_MESSAGE = 'message';
    protected const PROP_ERROR   = 'error';
    protected const PROP_TYPE    = 'type';

    private ?LoggerInterface $logger = null;

    private ?Serializer $serializer = null;

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * Serialize data to JSON string
     *
     * @param mixed $data
     * @return string
     */
    public function serialize(mixed $data): string
    {
        return $this->getSerializer()->serialize(
            $data,
            'json',
            [
                'circular_reference_handler' => function ($object) {
                    return null;
                }
            ]
        );
    }

    /**
     * @return Serializer
     */
    private function getSerializer(): Serializer
    {
        if (null === $this->serializer) {
            $this->serializer = new Serializer(
                [new ObjectNormalizer()],
                [new XmlEncoder(), new JsonEncoder()]
            );
        }

        return $this->serializer;
    }

    /**
     * @param ParameterBag $parameterBag
     *
     * @param array $criteria
     * @return array
     */
    protected function criteriaMapping(ParameterBag $parameterBag, array $criteria): array
    {
        $result = [];

        foreach ($criteria as $key => $default) {
            $result[$key] = $parameterBag->has($key) ? $parameterBag->get($key) : $default;
        }

        return $result;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function requestBody(Request $request): mixed
    {
        return json_decode($request->getContent(), true);
    }

    /**
     * @param Request $request
     * @param string $key
     * @return string|null
     */
    protected function getRequestParameter(Request $request, string $key): ?string
    {
        $body = $this->requestBody($request);
        
        return (array_key_exists($key, $body) && !empty($body[$key])) ? $body[$key] : null;
    }

    /**
     * @param RequestStack $requestStack
     * @param array|null $ignored
     * @return CriteriaDTO
     */
    protected function getCriteria(RequestStack $requestStack, array $ignored = null): CriteriaDTO
    {
        if ($ignored) {
            return new CriteriaDTO($requestStack, $ignored);
        }

        return new CriteriaDTO($requestStack);
    }

    /**
     * @param Exception $e
     * @param string $type
     * @return JsonResponse
     */
    protected function jsonErrorResponse(Exception $e, string $type = 'Exception'): JsonResponse
    {
        $responseBody = null;

        if ($this->getParameter('kernel.debug') || ($e->getCode() < 500 && !$e instanceof DBALException)) {
            $responseBody = [
                self::PROP_MESSAGE => $e->getMessage(),
                self::PROP_ERROR   => $type,
                self::PROP_TYPE    => $type,
            ];
        }

        $this->logger?->error($e->getMessage(), ['trace' => $e->getTraceAsString()]);

        return new JsonResponse(
            $responseBody ?? '',
            $e instanceof \HttpException ? $e->getCode() : Response::HTTP_BAD_REQUEST
        );
    }


}
