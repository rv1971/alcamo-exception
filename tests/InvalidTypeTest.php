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
            ],
            [
                [
                    'expectedOneOf' => [ 'bool' ]
                ],
                'Invalid type "NULL", expected one of ["bool"]'
            ]
        ];
    }

    public function testThrowIfNull(): void
    {
        InvalidType::throwIfNull(42);

        $this->expectException(InvalidType::class);

        $this->expectExceptionMessage(
            'Invalid type "null", expected one of ["Stringable", "array"]'
        );

        InvalidType::throwIfNull(null, [ 'Stringable', 'array' ]);
    }

    public function testThrowIfNullOrEmpty(): void
    {
        InvalidType::throwIfNullOrEmpty('0');

        $this->expectException(InvalidType::class);

        $this->expectExceptionMessage('Invalid type "<empty-string>"');

        InvalidType::throwIfNullOrEmpty('');
    }

    public function testThrowIfNullOrEmpty2(): void
    {
        $this->expectException(InvalidType::class);

        $this->expectExceptionMessage(
            'Invalid type "null", expected one of "<nonempty-string>"'
        );

        InvalidType::throwIfNullOrEmpty(null, '<nonempty-string>');
    }
}
