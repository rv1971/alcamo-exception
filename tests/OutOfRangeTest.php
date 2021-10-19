<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class OutOfRangeTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new OutOfRange(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [
                    'value' => 'NaN'
                ],
                'Value "NaN" out of range ["-∞", "∞"]'
            ],
            [
                [
                    'value' => 1,
                    'lowerBound' => 2
                ],
                'Value 1 out of range [2, "∞"]'
            ],
            [
                [
                    'value' => 0,
                    'upperBound' => -12
                ],
                'Value 0 out of range ["-∞", -12]'
            ],
            [
                [
                    'value' => 4,
                    'lowerBound' => 1,
                    'upperBound' => 3
                ],
                'Value 4 out of range [1, 3]'
            ]
        ];
    }

    /**
     * @dataProvider throwIfOutsideProvider
     */
    public function testThrowIfOutside(
        $expectedContext,
        $value,
        $lowerBound,
        $upperBound,
        $context
    ) {
        if (isset($expectedContext)) {
            try {
                OutOfRange::throwIfOutside(
                    $value,
                    $lowerBound,
                    $upperBound,
                    $context
                );
            } catch (OutOfRange $e) {
                $this->assertSame($expectedContext, $e->getMessageContext());

                return;
            }

            throw new Exception('No exception thrown.');
        } else {
            OutOfRange::throwIfOutside(
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
                null, 1, 0, null, null
            ],
            [
                null, 0, -7, 12, [ 'atUri' => '/somewhere' ]
            ],
            [
                [
                    'value' => 1,
                    'lowerBound' => 2,
                    'upperBound' => 42,
                ],
                1,
                2,
                42,
                null
            ],
            [
                [
                    'value' => -7,
                    'lowerBound' => -43,
                    'upperBound' => -8,
                    'atLine' => 17
                ],
                -7,
                -43,
                -8,
                [ 'atLine' => 17 ]
            ]
        ];
    }
}
