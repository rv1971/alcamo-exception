<?php

namespace alcamo\exception;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;

class AbsoluteUriNeededTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics(
        $normalizedMessage,
        $code,
        $previous,
        $context,
        $expectedMessage
    ) {
        $e = new AbsoluteUriNeeded(
            $normalizedMessage,
            $code,
            $previous,
            $context
        );

        $this->assertSame($code, $e->getCode());

        $this->assertSame($previous, $e->getPrevious());

        $this->assertSame($context, $e->getMessageContext());

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                null,
                0,
                null,
                [ 'uri' => 'foo/bar' ],
                'Relative URI "foo/bar" given where absolute URI is needed'
            ],
            [
                null,
                42,
                new \UnexpectedValueException(),
                [
                    'uri' => new Uri('baz.php?x=1'),
                    'atOffset' => 2,
                    'inData' => [ 3, 5, 'baz.php?x=1', 7.11, null, true ],
                    'inMethod' => 'runFoo',
                    'extraMessage' => 'lorem ipsum'
                ],
                'Relative URI "baz.php?x=1" given where absolute URI is needed'
                . ' in method "runFoo"'
                . ' in [3, 5, "baz.php?x=1", 7.11, <null>, <t...]'
                . ' at offset 2; lorem ipsum'
            ],
            [
                'Custom exception of type {foo}',
                43,
                null,
                [
                    'uri' => new Uri('/qux'),
                    'inData' => new \stdClass(),
                    'foo' => 'Foo'
                ],
                'Custom exception of type "Foo" in <stdClass>'
            ]
        ];
    }
}