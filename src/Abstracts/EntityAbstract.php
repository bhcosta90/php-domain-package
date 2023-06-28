<?php

declare(strict_types=1);

namespace BRCas\CA\Abstracts;

use BRCas\CA\Contracts\Entity\EntityInterface;
use BRCas\CA\Support\FieldTypeSupport;
use BRCas\CA\VO\Uuid;
use DateTime;
use Exception;
use ReflectionClass;
use Throwable;

abstract class EntityAbstract implements EntityInterface
{
    protected abstract function fieldsUpdated(): array;

    public function __construct(array $props = [])
    {
        $properties = $this->mapProperties();

        foreach ($props as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $this->verifyProperty($value, $properties[$key]);
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
        $properties = $this->mapProperties();

        foreach ($data as $prop => $value) {
            if (in_array($prop, $this->fieldsUpdated())) {
                $this->{$prop} = $this->verifyProperty($value, $properties[$prop]);
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

    public function toArray()
    {
        $data = [];
        $properties = $this->mapProperties();

        foreach (array_keys($properties) as $key) {
            try {
                if ($properties[$key] === 'bool') {
                    $value = (bool) $this->{$key};
                } else {
                    $value = (!empty($this->{$key}) && method_exists($this->{$key}, '__toString'))
                        ? $this->{$key}->__toString()
                        : $this->{$key};
                }

                if ($value instanceof EntityAbstract) {
                    $value = $value->id();
                }

                $data[$key] = $value;
            }catch(Throwable $e) {
                dump($key);
                throw $e;
            }
        }

        return $data;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        $className = get_class($this);
        throw new Exception("Property {$property} not found in class {$className}");
    }

    protected function validated(): void
    {
        //
    }

    protected function mapProperties(): array
    {
        $fieldType = new FieldTypeSupport(new ReflectionClass($this));
        return $fieldType->getProperties();
    }

    protected function verifyProperty($value, $type)
    {
        switch ($type) {
            case Uuid::class:
                $value = $value != Uuid::class ? new Uuid($value) : $value;
                break;
            case DateTime::class:
                $value = $value != DateTime::class ? new DateTime($value ?: "") : $value;
                break;
            case 'bool':
                $value = (bool) $value;
                break;
            default:
                return $value;
                break;
        }

        return $value;
    }
}
