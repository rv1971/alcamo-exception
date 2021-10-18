<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class InvalidEnumeratorTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new InvalidEnumerator(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [
                    'value' => 'fooo',
                    'expectedOneOf' => [ 'foo', 'bar', 'baz' ]
                ],
                'Invalid value "fooo", expected one of ["foo", "bar", "baz"]'
            ]
        ];
    }
}
