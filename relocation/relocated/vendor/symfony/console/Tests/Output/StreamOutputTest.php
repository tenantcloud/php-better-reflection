<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Output;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\Output;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput;
class StreamOutputTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    protected $stream;
    protected function setUp() : void
    {
        $this->stream = \fopen('php://memory', 'a', \false);
    }
    protected function tearDown() : void
    {
        $this->stream = null;
    }
    public function testConstructor()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput($this->stream, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\Output::VERBOSITY_QUIET, \true);
        $this->assertEquals(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\Output::VERBOSITY_QUIET, $output->getVerbosity(), '__construct() takes the verbosity as its first argument');
        $this->assertTrue($output->isDecorated(), '__construct() takes the decorated flag as its second argument');
    }
    public function testStreamIsRequired()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The StreamOutput class needs a stream as its first argument.');
        new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput('foo');
    }
    public function testGetStream()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput($this->stream);
        $this->assertEquals($this->stream, $output->getStream(), '->getStream() returns the current stream');
    }
    public function testDoWrite()
    {
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput($this->stream);
        $output->writeln('foo');
        \rewind($output->getStream());
        $this->assertEquals('foo' . \PHP_EOL, \stream_get_contents($output->getStream()), '->doWrite() writes to the stream');
    }
    public function testDoWriteOnFailure()
    {
        $resource = \fopen(__DIR__ . '/../Fixtures/stream_output_file.txt', 'r', \false);
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput($resource);
        \rewind($output->getStream());
        $this->assertEquals('', \stream_get_contents($output->getStream()));
    }
}
