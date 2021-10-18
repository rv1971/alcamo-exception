<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class DirectoryNotFoundTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new DirectoryNotFound(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [ 'path' => '/nowhere' ],
                'Directory "/nowhere" not found'
            ]
        ];
    }
}
