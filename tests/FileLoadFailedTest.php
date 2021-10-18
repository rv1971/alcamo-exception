<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class FileLoadFailedTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new FileLoadFailed(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [ 'filename' => 'loremipsum.txt' ],
                'Failed to load "loremipsum.txt"'
            ]
        ];
    }
}
