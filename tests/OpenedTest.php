<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class OpenedTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new Opened(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [ 'object' => 'foo.pipe' ],
                'Attempt to open already opened object "foo.pipe"'
            ]
        ];
    }
}
