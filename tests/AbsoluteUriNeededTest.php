<?php

namespace alcamo\exception;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;

class SpaceMessageFactory extends MessageFactory
{
    public const PLACEHOLDER_FLAGS = parent::PLACEHOLDER_FLAGS + [
        'onPlanet' => self::NO_QUOTE
    ];

    public const MESSAGE_FRAGMENT_MAP = parent::MESSAGE_FRAGMENT_MAP + [
        'onPlanet' => ' on planet %s'
    ];
}

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
            $context,
            new SpaceMessageFactory()
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
                    'extraMessage' => 'lorem ipsum',
                    'onPlanet' => 'Earth'
                ],
                'Relative URI <GuzzleHttp\Psr7\Uri>"baz.php?x=1" given'
                . ' where absolute URI is needed'
                . ' in method runFoo()'
                . ' in [3, 5, "baz.php?x=1", 7.11, <null>, <t...]'
                . ' at offset 2; lorem ipsum on planet Earth'
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

    public function testAddMessageContext()
    {
        $e =  (new AbsoluteUriNeeded())->setMessageContext(
            [
                'uri' => 'foo.html',
                'inMethod' => 'runFoo',
                'extraMessage' => 'dolor sit amet'
            ]
        );

        $this->assertSame(
            'Relative URI "foo.html" given where absolute URI is needed'
            . ' in method runFoo(); dolor sit amet',
            $e->getMessage()
        );

        $e->addMessageContext(
            [
                'uri' => 'bar.html',
                'extraMessage' => 'consetetur sadipscing elitr',
                'inData' => (object)[],
                'onPlanet' => 'Mercury'
            ]
        );

        $this->assertSame(
            'Relative URI "bar.html" given where absolute URI is needed'
            . ' in method runFoo() in <stdClass>; consetetur sadipscing elitr',
            $e->getMessage()
        );

        $e->addMessageContext([], new SpaceMessageFactory());

        $this->assertSame(
            'Relative URI "bar.html" given where absolute URI is needed'
            . ' in method runFoo() in <stdClass>; consetetur sadipscing elitr'
            . ' on planet Mercury',
            $e->getMessage()
        );
    }
}
