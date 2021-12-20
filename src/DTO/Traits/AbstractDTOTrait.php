<?php


namespace App\DTO\Traits;

trait AbstractDTOTrait
{
    /**
     * DTO constructor
     *
     * @param $properties object|array
     */
    public function __construct(object|array $properties = [])
    {
        $properties = $this->getObjectProperties($properties);

        if (method_exists($this, 'exchangeArray')) {
            $this->exchangeArray($properties);
        } else {
            foreach (array_keys(get_class_vars(static::class)) as $name) {
                $this->setPropertyValue($name, $properties);
            }
        }
    }

    /**
     * @param mixed $properties
     * @return array
     */
    private function getObjectProperties(mixed $properties): array
    {
        return is_object($properties) && $properties instanceof static ?
            get_object_vars($properties) : (array) $properties;
    }

    /**
     * @param string $property
     * @param array $properties
     */
    private function setPropertyValue(string $property, array $properties): void
    {
        if (!array_key_exists($property, $properties)) {
            return;
        }

        $method = 'set' . ucfirst($property);
        if (method_exists(static::class, $method)) {
            $this->$method($properties[$property]);
        } else {
            $this->$property = $properties[$property];
        }
    }
}
