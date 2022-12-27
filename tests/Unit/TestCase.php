<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase as FrameworkTestCase;

class TestCase extends FrameworkTestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
