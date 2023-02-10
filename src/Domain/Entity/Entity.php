<?php

namespace Costa\DomainPackage\Domain\Entity;

use Costa\DomainPackage\Domain\Event\EventInterface;
use Costa\DomainPackage\Domain\Notification\Notification;
use Costa\DomainPackage\Util\FieldType;
use Costa\DomainPackage\ValueObject\Uuid;
use DateTime;
use ReflectionClass;

abstract class Entity
{
    protected $attributes = [];

    protected abstract function fieldsUpdated(): array;

    protected abstract function validated(): bool;

    private ?Notification $notification = null;

    /** @var EventInterface */
    private array $events = [];

    use Trait\EntityTrait, Trait\MethodsMagicsTrait;

    public function __construct(array $props = [])
    {
        $fieldType = new FieldType(new ReflectionClass($this));
        $properties = $fieldType->getProperties();
        foreach ($properties as $property) {
            if (empty($this->{$property['name']})) {
                if ($property['type'] == Uuid::class) {
                    $this->{$property['name']} = Uuid::random();
                    $this->attributes[$property['name']] = $this->{$property['name']};
                }
                if ($property['type'] == DateTime::class) {
                    $this->{$property['name']} = new DateTime;
                    $this->attributes[$property['name']] = $this->{$property['name']};
                }
            }
        }


        foreach ($props as $prop => $value) {
            $this->{$prop} = $value;
            $this->attributes[$prop] = $value;
        }

        foreach ($properties as $property) {
            if (!isset($this->{$property['name']})) {
                $this->{$property['name']} = null;
                $this->attributes[$property['name']] = null;
            }
        }


        $this->validated();
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function update(array $props)
    {
        foreach ($props as $prop => $value) {
            if (in_array($prop, $this->fieldsUpdated())) {
                $this->{$prop} = $value;
            }
        }

        $this->validated();
    }

    public function getNotification()
    {
        if (!$this->notification) {
            $this->notification = new Notification();
        }

        return $this->notification;
    }

    public function addEvent(EventInterface $event)
    {
        $this->events[] = $event;
    }
}
