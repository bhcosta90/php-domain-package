<?php

declare(strict_types=1);

namespace BRCas\CA\Abstracts;

use BRCas\CA\Support\FieldTypeSupport;
use BRCas\CA\VO\Uuid;
use Core\Company\Company\Domain\Company;
use DateTime;
use ReflectionClass;

abstract class EntityAbstract
{
    public function update(array $data)
    {
        $data = self::setAttributes($data);
        $data = self::setAttributeWhenIsEmpty($data);
        
        foreach($data as $key => $value) {
            if (in_array($key, $this->fillable())) {
                $this->{$key} = $value;
            }
        }
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
                switch ($properties[$key]) {
                    case 'bool':
                        $value = (bool) $this->{$key};
                        break;
                    case 'float':
                        $value = (float) $this->{$key};
                        break;
                    case 'int':
                        $value = (int)
                        $this->{$key};
                        break;
                    default:
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

        if (get_called_class() == Company::class) {
            dump($data);
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

    protected function fillable(): array
    {
        return [];
    }

    private static function setAttributes(array $data)
    {
        $fields = (new FieldTypeSupport(new ReflectionClass(get_called_class())))->getProperties();
        $readData = [];

        foreach ($data as $key => $value) {
            if (!empty($value) && array_key_exists($key, $fields)) {
                switch ($fields[$key]) {
                    case Uuid::class:
                        $readData[$key] = new Uuid($value);
                        break;
                    case DateTime::class:
                        $readData[$key] = new DateTime($value);
                        break;
                    case 'float':
                        $readData[$key] = (float) $value;
                        break;
                    case 'bool':
                        $readData[$key] = (bool) $value;
                        break;
                    default:
                        $readData[$key] = $data[$key] ?? null;
                        break;
                }

            }
        }

        return $readData;
    }

    private static function setAttributeWhenIsEmpty(array $data)
    {
        $fields = (new FieldTypeSupport(new ReflectionClass(get_called_class())))->getProperties();
        $readData = [];

        foreach ($fields as $key => $value) {
            if (empty($data[$key])) {
                switch ($value) {
                    case Uuid::class:
                        $data[$key] = Uuid::random();
                        break;
                    case DateTime::class:
                        $data[$key] = new DateTime();
                        break;
                    case 'bool':
                        $data[$key] = false;
                        break;
                    case 'float':
                        $data[$key] = 0;
                        break;
                    case 'array':
                        $data[$key] = [];
                        break;
                    default:
                        break;
                }
            }

            $readData[$key] = $data[$key] ?? null;
        }

        return $readData;
    }    
}
