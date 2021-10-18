<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class UnsupportedTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new Unsupported(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [ 'feature' => 'Doubling the cube' ],
                '"Doubling the cube" not supported'
            ]
        ];
    }
}
