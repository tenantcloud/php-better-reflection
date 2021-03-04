<?php

namespace TenantCloud\BetterReflection\Relocated\RingCentral\Tests\Psr7;

use TenantCloud\BetterReflection\Relocated\RingCentral\Psr7;
use TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\NoSeekStream;
/**
 * @covers RingCentral\Psr7\NoSeekStream
 * @covers RingCentral\Psr7\StreamDecoratorTrait
 */
class NoSeekStreamTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Cannot seek a NoSeekStream
     */
    public function testCannotSeek()
    {
        $s = $this->getMockBuilder('TenantCloud\\BetterReflection\\Relocated\\Psr\\Http\\Message\\StreamInterface')->setMethods(array('isSeekable', 'seek'))->getMockForAbstractClass();
        $s->expects($this->never())->method('seek');
        $s->expects($this->never())->method('isSeekable');
        $wrapped = new \TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\NoSeekStream($s);
        $this->assertFalse($wrapped->isSeekable());
        $wrapped->seek(2);
    }
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Cannot write to a non-writable stream
     */
    public function testHandlesClose()
    {
        $s = \TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\stream_for('foo');
        $wrapped = new \TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\NoSeekStream($s);
        $wrapped->close();
        $wrapped->write('foo');
    }
}
