<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class MethodNotFoundTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new MethodNotFound(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [ 'method' => 'runFooo' ],
                'Method "runFooo" not found'
            ]
        ];
    }
}
