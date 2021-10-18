<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class LockedTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new Locked(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [
                    'object' => 'someObject'
                ],
                'Attempt to modify locked object "someObject"'
            ]
        ];
    }
}
