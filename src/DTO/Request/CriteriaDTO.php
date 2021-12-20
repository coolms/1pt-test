<?php


namespace App\DTO\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class QueryDTO
 */
class CriteriaDTO
{

    public const PARAM_LIMIT    = 'limit';
    public const PARAM_PAGE     = 'page';
    public const DEFAULT_LIMIT  = 10;
    public const DEFAULT_PAGE   = 1;

    private int $limit = self::DEFAULT_LIMIT;

    private int $page = self::DEFAULT_PAGE;

    private array $filter = [];

    private array $ignored = [];

    /**
     * QueryDTO constructor.
     *
     * @param RequestStack $requestStack
     * @param array<string> $ignored
     */
    public function __construct(RequestStack $requestStack, array $ignored = [self::PARAM_PAGE, self::PARAM_LIMIT])
    {
        $request = $requestStack->getCurrentRequest();
        $this->setFilter($request);
        $this->setLimit((int) $request->query->get(self::PARAM_LIMIT, self::DEFAULT_LIMIT));
        $this->setPage((int) $request->query->get(self::PARAM_PAGE, self::DEFAULT_PAGE));
        $this->ignored = $ignored;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param  int  $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param  int  $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return ($this->page - 1) * $this->limit;
    }

    /**
     * @return array
     */
    public function getFilter(): array
    {
        return $this->filter;
    }

    /**
     * @param Request $request
     */
    private function setFilter(Request $request): void
    {
        foreach ($request->query->all() as $name => $value) {
            if (in_array($name, $this->ignored)) {
                continue;
            }

            $this->filter[$name] = $value;
        }
    }


}
