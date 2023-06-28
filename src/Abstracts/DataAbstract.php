<?php

declare(strict_types=1);

namespace BRCas\CA\Abstracts;

use BRCas\CA\Support\FieldTypeSupport;
use BRCas\CA\VO\Uuid;
use DateTime;
use ReflectionClass;

abstract class DataAbstract
{
    public function update(array $data)
    {
        self::from($data);
    }

    public static function from(array $data): static
    {
        $data = self::setAttributes($data);
        $data = self::setAttributeWhenIsEmpty($data);
        return new static(...$data);
    }

    public function id(): string
    {
        if (empty($this->id)) {
            $this->id = Uuid::random();
        }

        return $this->id->__toString();
    }

    public function createdAt(): string
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new DateTime();
        }

        return $this->createdAt->format('Y-m-d H:i:s');
    }

    public function toArray(): array
    {
        $data = [];
        $properties = (new FieldTypeSupport(new ReflectionClass($this)))->getProperties();

        foreach (array_keys($properties) as $key) {
            try {
                if ($properties[$key] === 'bool') {
                    $value = (bool) $this->{$key};
                } else {
                    $value = (!empty($this->{$key}) && method_exists($this->{$key}, '__toString'))
                    ? $this->{$key}->__toString()
                        : $this->{$key};
                }

                if ($value instanceof DataAbstract) {
                    $value = $value->id();
                }

                $data[$key] = $value;
            } catch (Throwable $e) {
                dump($key);
                throw $e;
            }
        }
        $data['id'] = $this->id();
        $data['createdAt'] = $this->createdAt();

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

    private static function setAttributes(array $data)
    {
        $fields = (new FieldTypeSupport(new ReflectionClass(get_called_class())))->getProperties();
        $readData = [];

        foreach ($data as $key => $value) {
            if (!empty($value) && array_key_exists($key, $fields)) {
                if ($fields[$key] === Uuid::class) {
                    $data[$key] = new Uuid($value);
                }

                if ($fields[$key] === DateTime::class) {
                    $data[$key] = new DateTime($value);
                }

                $readData[$key] = $data[$key] ?? null;
            }
        }

        return $readData;
    }

    private static function setAttributeWhenIsEmpty(array $data)
    {
        $fields = (new FieldTypeSupport(new ReflectionClass(get_called_class())))->getProperties();
        $readData = [];

        foreach ($fields as $key => $value) {
            if ($value === Uuid::class && empty($data[$key])) {
                $data[$key] = Uuid::random();
            }

            if ($value === DateTime::class && empty($data[$key])) {
                $data[$key] = new DateTime();
            }

            if ($value === 'bool' && empty($data[$key])) {
                $data[$key] = false;
            }

            $readData[$key] = $data[$key] ?? null;
        }

        return $readData;
    }
}
