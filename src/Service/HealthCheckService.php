<?php


namespace App\Service;

class HealthCheckService extends AbstractService
{
    private array $healthCheckItems = [];

    public function setHealthCheckItems(HealthCheckItemInterface ...$healthCheckItems): void
    {
        foreach ($healthCheckItems as $healthCheckItem) {
            $this->addHealthCheckItem($healthCheckItem);
        }
    }

    public function addHealthCheckItem(HealthCheckItemInterface $healthCheckItem): void
    {
        $this->healthCheckItems[$healthCheckItem->getName()] = $healthCheckItem;
    }

    public function getHealthCheckItem(string $name): ?HealthCheckItemInterface
    {
        return $this->healthCheckItems[$name] ?? null;
    }

    /**
     * @return array|HealthCheckItemInterface[]
     */
    public function getHealthCheckItems(): array
    {
        return $this->healthCheckItems;
    }

    /**
     * @deprecated Use HealthCheckItemInterface::getValue() instead
     * @return bool|float|null
     */
    public function getDiskFreeSpace(): bool|float|null
    {
        return $this->getHealthCheckItem('freeDiscSpace')?->getValue();
    }

    /**
     * @deprecated Use HealthCheckItemInterface::getValue() instead
     * @param bool $real_usage
     * @return int|null
     */
    public function getMemoryUsage(bool $real_usage = false): ?int
    {
        return $this->getHealthCheckItem('memoryUsage')?->getValue($real_usage);
    }

}
