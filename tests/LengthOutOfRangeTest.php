<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class LengthOutOfRangeTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new LengthOutOfRange(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [
                    'value' => "f",
                    'length' => 1,
                    'lowerBound' => 2
                ],
                'Length 1 of "f" out of range [2, "∞"]'
            ],
            [
                [
                    'value' => "foo",
                    'length' => 3,
                    'upperBound' => 2
                ],
                'Length 3 of "foo" out of range [0, 2]'
            ],
            [
                [
                    'value' => "bar-baz",
                    'length' => 7,
                    'lowerBound' => 1,
                    'upperBound' => 6
                ],
                'Length 7 of "bar-baz" out of range [1, 6]'
            ]
        ];
    }

    /**
     * @dataProvider throwIfOutsideProvider
     */
    public function testThrowIfOutside(
        $value,
        $length,
        $lowerBound,
        $upperBound,
        $context,
        $expectedContext,
        $expectedMessage
    ) {
        if (isset($expectedContext)) {
            try {
                LengthOutOfRange::throwIfOutside(
                    $value,
                    $lowerBound,
                    $upperBound,
                    $context
                );
            } catch (LengthOutOfRange $e) {
                $this->assertSame($expectedContext, $e->getMessageContext());

                $this->assertSame($expectedMessage, $e->getMessage());

                return;
            }

            throw new Exception('No exception thrown.');
        } else {
            LengthOutOfRange::throwIfOutside(
                $value,
                $lowerBound,
                $upperBound,
                $context
            );

            $this->assertTrue(true);
        }
    }

    public function throwIfOutsideProvider()
    {
        return [
            [
                "quux", null, null, null, null, null, null
            ],
            [
                'foo',
                null,
                4,
                42,
                null,
                [
                    'value' => 'foo',
                    'length' => 3,
                    'lowerBound' => 4,
                    'upperBound' => 42
                ],
                'Length 3 of "foo" out of range [4, 42]'
            ],
            [
                'bar',
                null,
                4,
                null,
                null,
                [
                    'value' => 'bar',
                    'length' => 3,
                    'lowerBound' => 4,
                    'upperBound' => '∞'
                ],
                'Length 3 of "bar" out of range [4, "∞"]'
            ]
        ];
    }
}
