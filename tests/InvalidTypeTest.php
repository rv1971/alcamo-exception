<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class InvalidTypeTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new InvalidType(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [
                    'type' => 'int',
                    'expectedOneOf' => [ 'string' ]
                ],
                'Invalid type "int", expected one of ["string"]'
            ],
            [
                [
                    'value' => (object)[ 'foo' => 'bar'],
                    'expectedOneOf' => [ 'array' ]
                ],
                'Invalid type "stdClass", expected one of ["array"]'
            ],
            [
                [
                    'value' => (object)[ 'foo' => 'bar'],
                    'type' => 'bool',
                    'expectedOneOf' => [ 'array' ]
                ],
                'Invalid type "bool", expected one of ["array"]'
            ]
        ];
    }
}
