<?php


namespace App\Service;

use App\DTO\IdentifiableDTO;
use App\Entity\IdentifiableInterface;
use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\Exception\UnregisteredMappingException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AbstractService
 */
abstract class AbstractService
{

    protected EntityManagerInterface $em;

    protected AutoMapperInterface $autoMapper;

    /**
     * @param object $object
     * @return void
     */
    public function persist(object $object): void
    {
        try {
            $this->em->persist($object);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * @return void
     */
    public function savePersisted(): void
    {
        try {
            $this->em->flush();
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * Saves specified Entity
     *
     * @param object $object
     * @param bool $flush
     * @return object
     */
    public function save(object $object, bool $flush = true): object
    {
        $this->em->persist($object);

        if ($flush) {
            $this->em->flush();
        }

        return $object;
    }

    /**
     * Removes specified Entity
     *
     * @param object $object
     * @param bool $flush
     * @return object
     */
    public function remove(object $object, bool $flush = true): object
    {
        $this->em->remove($object);

        if ($flush) {
            $this->em->flush();
        }

        return $object;
    }

    /**
     * @param IdentifiableInterface $entity
     * @return IdentifiableDTO
     * @throws UnregisteredMappingException
     */
    public function toIdentifiableDTO(IdentifiableInterface $entity): IdentifiableDTO
    {
        try {

            return $this->autoMapper->map($entity, IdentifiableDTO::class);

        } catch (UnregisteredMappingException $e) {

            throw $e;

        }
    }

    /**
     * @param AutoMapperInterface $autoMapper
     */
    public function setAutoMapper(AutoMapperInterface $autoMapper): void
    {
        $this->autoMapper = $autoMapper;
    }

    /**
     * @param EntityManagerInterface $em
     */
    public function setEntityManager(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }


}
