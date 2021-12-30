<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class DataNotFoundTest extends TestCase
{
    public function testBasics()
    {
        $e = new DataNotFound();

        $this->assertSame('Data not found', $e->getMessage());
    }
}
