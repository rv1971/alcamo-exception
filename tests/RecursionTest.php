<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class RecursionTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new Recursion(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [], 'Recursion detected'
            ]
        ];
    }
}
