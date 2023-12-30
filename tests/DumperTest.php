<?php

namespace alcamo\exception;

use PHPUnit\Framework\TestCase;

class DumperTest extends TestCase
{
    /**
     * @dataProvider dumpProvider
     */
    public function testDump($e, $expectedText): void
    {
        $dumper = new Dumper();

        $this->assertSame($expectedText, $dumper->dump($e));
    }

    public function dumpProvider(): array
    {
        $e = (new ReadonlyViolation())->setMessageContext(
            [ 'object' => '$barBaz' ]
        );

        $e->qux = true;

        return [
            [
                (new Unsupported())->setMessageContext([ 'feature' => 'foo' ]),
                <<<'EOT'
alcamo\exception\Unsupported
  at /home/rizzardo/src/alcamo-exception/tests/DumperTest.php:29
  "foo" not supported
* feature = "foo"

EOT
            ],
            [
                $e,
                <<<'EOT'
alcamo\exception\ReadonlyViolation
  at /home/rizzardo/src/alcamo-exception/tests/DumperTest.php:21
  Attempt to modify readonly object "$barBaz" in method dumpProvider()
* object = "$barBaz"
* inMethod = "dumpProvider"
* qux = <true>

EOT
            ]
        ];
    }
}
