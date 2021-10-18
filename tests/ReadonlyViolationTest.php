<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class ReadonlyViolationTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new ReadonlyViolation(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [ 'object' => 'const' ],
                'Attempt to modify readonly object "const"'
            ]
        ];
    }
}
