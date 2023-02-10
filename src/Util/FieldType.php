<?php

namespace Costa\DomainPackage\Util;

use ReflectionClass;
use TypeError;

class FieldType
{
    protected array $props;

    public function __construct(private ReflectionClass $reflect)
    {
        $this->props = $reflect->getProperties();
    }

    public function getProperties()
    {
        $result = [];
        foreach ($this->props as $props) {
            $prop = $this->reflect->getProperty($props->getName());
            $prop->setAccessible(true);

            $result[] = [
                'name' => $props->getName(),
                'type' => $prop->getType()?->getName(),
            ];
        }

        return $result;
    }
}
