<?php


namespace App\DTO\Traits;

use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait for nameable DTOs
 */
trait IdentifiableDTOTrait
{
    /**
     * @OA\Property(type="string", description="Read-only property.", readOnly=true)
     * @Assert\Blank()
     */
    public string $id;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
