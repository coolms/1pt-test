<?php


namespace App\Service;

interface HealthCheckItemInterface extends \JsonSerializable
{

    public function getName(): string;

    public function getStatus(): bool;

    public function getValue(): mixed;

}
