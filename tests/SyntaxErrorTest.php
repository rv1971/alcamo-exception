<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class SyntaxErrorTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new SyntaxError(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [ 'inData' => "\x00\r\n" ], 'Syntax error in "\000\r\n"'
            ]
        ];
    }

    public function testNewFromPrevious()
    {
        $previous = new \Exception('Lorem ipsum', 1234);

        $e = SyntaxError::newFromPrevious($previous, [ 'atLine' => 42 ]);

        $this->assertSame(
            'Syntax error at line 42; Lorem ipsum',
            $e->getMessage()
        );

        $this->assertSame($previous->getCode(), $e->getCode());

        $this->assertSame($previous, $e->getPrevious());
    }
}
