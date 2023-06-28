<?php

declare(strict_types=1);

namespace BRCas\CA\Abstracts;

use BRCas\CA\Contracts\Entity\EntityInterface;
use BRCas\CA\Support\FieldTypeSupport;
use BRCas\CA\VO\Uuid;
use DateTime;
use Exception;
use ReflectionClass;

abstract class EntityAbstractCopy implements EntityInterface
{
    protected abstract function fieldsUpdated(): array;

    public function __construct(array $props = [])
    {
        $properties = $this->mapProperties();

        foreach ($props as $key => $value) {
            if (property_exists($this, $key) && !empty($value)) {
                switch ($properties[$key]) {
                    case Uuid::class:
                        $this->{$key} = new Uuid($value);
                        break;
                    case DateTime::class:
                        $this->{$key} = new DateTime($value);
                        break;
                    default:
                        $this->{$key} = $value;
                        break;
                }
            }
        }

        if (
            property_exists($this, 'id')
            && empty($this->id)
            && $properties['id'] == Uuid::class
        ) {
            $this->id = Uuid::random();
        }

        if (
            property_exists($this, 'createdAt')
            && empty($this->createdAt)
            && $properties['createdAt'] == DateTime::class
        ) {
            $this->createdAt = new DateTime;
        }

        $this->validated();
    }

    public function update(array $data = [])
    {
        foreach ($data as $prop => $value) {
            if (in_array($prop, $this->fieldsUpdated())) {
                $this->{$prop} = $value;
            }
        }

        $this->validated();
    }

    public function id(): string
    {
        return (string) $this->id;
    }

    public function createdAt($format = 'Y-m-d H:i:s'): string
    {
        return $this->createdAt->format($format);
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        $className = get_class($this);
        throw new Exception("Property {$property} not found in class {$className}");
    }

    public function toArray()
    {
        $data = [];
        $properties = $this->mapProperties();

        foreach (array_keys($properties) as $key) {
            switch ($properties[$key]) {
                case Uuid::class:
                case DateTime::class:
                    $data[$key] = (string) $this->{$key};
                    break;
                case 'bool':
                    $data[$key] = (bool) $this->{$key};
                    break;
                case 'float':
                    $data[$key] = $this->{$key};
                    break;
                default:
                    $data[$key] = method_exists($this->{$key}, 'toArray') ? $this->{$key}->toArray() : $this->{$key};
                    break;
            }
        }

        return $data;
    }

    protected function validated(): void
    {
        //
    }

    private function mapProperties(): array
    {
        $fieldType = new FieldTypeSupport(new ReflectionClass($this));
        return $fieldType->getProperties();
    }
}
