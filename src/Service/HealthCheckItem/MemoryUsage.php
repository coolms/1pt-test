<?php


namespace App\Service\HealthCheckItem;

use App\Service\HealthCheckItemInterface;

class MemoryUsage implements HealthCheckItemInterface
{
    public function getName(): string
    {
        return 'memoryUsage';
    }

    /**
     * More complex logic can be placed here
     *
     * @param bool $real_usage
     * @return bool
     */
    public function getStatus(bool $real_usage = false): bool
    {
        return $this->getValue($real_usage) > 0;
    }

    public function getValue(bool $real_usage = false): int
    {
        return memory_get_usage($real_usage);
    }

    public function jsonSerialize()
    {
        return $this->getStatus();
    }
}
