<?php


namespace App\Entity;

use Ramsey\Uuid\UuidInterface;

interface IdentifiableInterface
{

    public const PROP_ID = 'id';

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface;


}
