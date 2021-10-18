<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class UninitializedTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new Uninitialized(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [ 'object' => (object)[] ],
                'Attempt to access uninitialized object <stdClass>'
            ]
        ];
    }
}
