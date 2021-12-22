<?php


namespace App\Service\HealthCheckItem;

use App\Service\HealthCheckItemInterface;

class DiscFreeSpace implements HealthCheckItemInterface
{
    public function getName(): string
    {
        return 'freeDiscSpace';
    }

    /**
     * More complex logic can be placed here
     *
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->getValue() > 0;
    }

    public function getValue(): false|float
    {
        return disk_free_space('/');
    }

    public function jsonSerialize()
    {
        return $this->getStatus();
    }
}
