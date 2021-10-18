<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class UnderflowTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new Underflow(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [ 'object' => 'stack' ],
                'Underflow in object "stack"'
            ]
        ];
    }
}
