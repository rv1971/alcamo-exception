<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class AbsolutePathNeededTest extends TestCase
{
    public function testBasics()
    {
        $e = (new AbsolutePathNeeded())
            ->setMessageContext([ 'path' => 'bar/baz' ]);

        $this->assertSame(
            'Relative path "bar/baz" given where absolute path is needed',
            $e->getMessage()
        );
    }
}
