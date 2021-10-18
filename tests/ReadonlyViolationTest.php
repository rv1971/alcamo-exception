<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class Baz
{
    public function throwReadonlyViolation()
    {
        throw new ReadonlyViolation();
    }
}

class ReadonlyViolationTest extends TestCase
{
    public function testBasics()
    {
        try {
            (new Baz())->throwReadonlyViolation();
        } catch (ReadonlyViolation $e) {
            $this->assertSame(
                'Attempt to modify readonly object <alcamo\exception\Baz>'
                . ' in method "throwReadonlyViolation"',
                $e->getMessage()
            );

            return;
        }

        throw new Exception('No exception thrown.');
    }
}
