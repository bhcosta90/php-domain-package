<?php

declare(strict_types=1);

use BRCas\CA\ValueObject\Password;

use Costa\Entity\Interfaces\ValueObjectInterface;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertTrue;

describe("Password Unit Test", function(){
    test("Make a password", function(){
        $password = Password::make(password: '123456');
        assertInstanceOf(ValueObjectInterface::class, $password);
        assertIsString((string) $password);
    });

    test("Creating a new password", function(){
        $password = new Password(value: '123456');
        assertInstanceOf(ValueObjectInterface::class, $password);
    });

    test("Login with a password", function(){
        $password = new Password(value: '$2y$10$Aq661ddSO9FqxCaxTDiO9Oc6BW4aNN8QqhAh8Ts.GtLSbX3Deszdy');
        assertTrue($password->login('123456'));
    });

    test("Exception when do not passed password", function(){
        expect(fn() => Password::make(null))->toThrow('password do not passed');
    });
});