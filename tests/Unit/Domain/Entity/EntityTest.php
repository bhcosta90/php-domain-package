<?php

namespace Tests\Unit\Costa\DomainPackage\Domain\Entity\Trait;

use Costa\DomainPackage\Domain\Entity\Entity;
use Costa\DomainPackage\ValueObject\Uuid;
use DateTime;
use Tests\Unit\TestCase;

class StubEntity extends Entity
{
    public ?Uuid $id;
    public string $name;
    public DateTime $createdAt;

    protected function fieldsUpdated(): array
    {
        return [
            'name'
        ];
    }

    protected function validated(): bool
    {
        return true;
    }
}

class EntityTest extends TestCase
{
    public function testConstructor()
    {
        $obj = new StubEntity([
            'name' => 'test'
        ]);
        $this->assertNotEmpty($obj->id());
        $this->assertNotEmpty($obj->createdAt());
        $this->assertEquals('test', $obj->name);
    }

    public function testUpdate()
    {
        $obj = new StubEntity([
            'id' => new Uuid('316d8b18-f2ab-457f-b485-8c5553c094d2'),
            'name' => 'test'
        ]);
        $this->assertEquals('test', $obj->name);

        $obj->update([
            'id' => Uuid::random(),
            'name' => 'oi',
        ]);
        $this->assertEquals('316d8b18-f2ab-457f-b485-8c5553c094d2', (string) $obj->id);
        $this->assertEquals('oi', $obj->name);
    }
}
