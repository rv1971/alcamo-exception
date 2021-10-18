<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class DataValidationFailedTest extends TestCase
{
    /**
     * @dataProvider basicsProvider
     */
    public function testBasics($context, $expectedMessage)
    {
        $e = new DataValidationFailed(null, 0, null, $context);

        $this->assertSame($expectedMessage, $e->getMessage());
    }

    public function basicsProvider()
    {
        return [
            [
                [
                    'atUri' => 'foo.xml',
                    'atLine' => 42
                ],
                'Validation failed at line 42 at URI "foo.xml"'
            ],
            [
                [
                    'inData' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr,',
                    'atOffset' => 18
                ],
                'Validation failed'
                . ' in "Lorem ipsum dolor sit amet, consetetu..."'
                . ' at offset 18 ("sit amet, consetetur sadipscing elitr,")'
            ],
            [
                [
                    'inData' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr,',
                    'atOffset' => 6
                ],
                'Validation failed'
                . ' in "Lorem ipsum dolor sit amet, consetetu..."'
                . ' at offset 6 ("ipsum dolor sit amet, consetetur sadi...")'
            ]
        ];
    }
}
