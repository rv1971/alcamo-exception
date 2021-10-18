<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class PopenFailedTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new PopenFailed(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [
                    'command' => '/usr/local/bin/foo',
                    'inMode' => 'in'
                ],
                'Failed to open process "/usr/local/bin/foo" in mode "in"'
            ],
            [
                [
                    'command' =>
                    [ '/usr/local/bin/foo', '-v', '-o', 'baz.json' ]
                ],
                'Failed to open process "/usr/local/bin/foo -v -o baz.json"'
            ]
        ];
    }
}
