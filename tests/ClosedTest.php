<?php

namespace alcamo\exception;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;

class ClosedTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new Closed(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [
                    'atUri' => new Uri('http:://closed.example.org')
                ],
                'Attempt to use closed object <alcamo\exception\ClosedTest>'
                . ' at URI "http:://closed.example.org"'
            ]
        ];
    }
}
