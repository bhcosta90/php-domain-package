<?php

namespace Tests\Unit\Costa\DomainPackage\ValueObject;

use Costa\DomainPackage\ValueObject\Password;
use Tests\Unit\TestCase;

class PasswordTest extends TestCase
{
    public function testLoginPassword()
    {
        $password = new Password("123456");
        $this->assertNotEquals((string) $password, '123456');
        $this->assertTrue($password->login('123456'));
    }
}
