<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class ProcessFailedTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new ProcessFailed(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [
                    'command' => '/usr/local/bin/foo',
                    'inDirectory' => '/home/alice'
                ],
                'Process "/usr/local/bin/foo" failed in directory "/home/alice"'
            ],
            [
                [
                    'command' =>
                    [ '/usr/local/bin/foo', '-v', '-o', 'baz.json' ]
                ],
                'Process "/usr/local/bin/foo -v -o baz.json" failed'
            ]
        ];
    }
}
