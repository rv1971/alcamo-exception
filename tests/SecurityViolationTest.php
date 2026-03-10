<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class SecurityViolationTest extends TestCase
{
    public function testBasics()
    {
        $e = new SecurityViolation();

        $this->assertSame('Security Violation', $e->getMessage());
    }
}
