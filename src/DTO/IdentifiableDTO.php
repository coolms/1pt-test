<?php


namespace App\DTO;

/**
 * Class IdentifiableDTO
 */
class IdentifiableDTO implements AbstractDTOInterface
{
    use Traits\AbstractDTOTrait,
        Traits\IdentifiableDTOTrait;

}
