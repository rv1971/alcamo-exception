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
}
