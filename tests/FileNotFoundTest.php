<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class FileNotFoundTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new FileNotFound(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [
                    'filename' => 'foo.conf',
                    'inPlaces' => [ '/etc', '/usr/local/etc' ]
                ],
                'File "foo.conf" not found in ["/etc", "/usr/local/etc"]'
            ],
            [
                [
                    'filename' => 'bar.cfg',
                    'inPlaces' => '/usr/local/etc:/etc'
                ],
                'File "bar.cfg" not found in "/usr/local/etc:/etc"'
            ]
        ];
    }
}
