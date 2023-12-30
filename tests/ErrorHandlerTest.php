<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class ErrorHandlerTest extends TestCase
{
    /**
     * @dataProvider handlerProvider
     */
    public function testHandler($msg, $type)
    {
        $errorHandler = new ErrorHandler($type);

        try {
            trigger_error($msg, $type);
        } catch (\ErrorException $e) {
            $this->assertSame($msg, $e->getMessage());
            $this->assertSame($type, $e->getSeverity());
            $this->assertSame(__FILE__, $e->getFile());
            $this->assertSame(17, $e->getLine());

            return;
        }

        $this->assertTrue(false);
    }

    public function handlerProvider()
    {
        return [
            'error' => [ 'Lorem ipsum', E_USER_ERROR ],
            'warning' => [ 'dolor sit amet', E_USER_WARNING ],
            'notice' => [ 'consetetur sadipscing elitr', E_USER_NOTICE ]
        ];
    }
}
