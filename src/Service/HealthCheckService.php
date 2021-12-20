<?php


namespace App\Service;

class HealthCheckService extends AbstractService
{

    /**
     * @return string
     */
    public function getDiskFreeSpace(): string
    {
        return disk_free_space('/');
    }

    /**
     * @param bool $real_usage
     * @return int
     */
    public function getMemoryUsage(bool $real_usage = false): int
    {
        return memory_get_usage($real_usage);
    }

}
