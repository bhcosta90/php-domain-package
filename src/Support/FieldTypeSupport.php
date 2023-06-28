<?php

declare(strict_types=1);

namespace BRCas\CA\Support;

use ReflectionClass;

class FieldTypeSupport
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
            $result[$props->getName()] = $prop->getType()?->getName();
        }

        return $result;
    }
}
