<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class Bar {
};

class EofTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new Eof(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [
                    'object' => new Bar(),
                    'availableUnits' => 7,
                    'requestedUnits' => 12
                ],
                'Failed to read 12 unit(s) from <alcamo\exception\Bar>'
                . ', only 7 units available'
            ]
        ];
    }
}
