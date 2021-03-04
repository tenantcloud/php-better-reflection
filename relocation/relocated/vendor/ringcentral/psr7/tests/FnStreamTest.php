<?php

namespace TenantCloud\BetterReflection\Relocated\RingCentral\Tests\Psr7;

use TenantCloud\BetterReflection\Relocated\RingCentral\Psr7;
use TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\FnStream;
/**
 * @covers RingCentral\Psr7\FnStream
 */
class FnStreamTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage seek() is not implemented in the FnStream
     */
    public function testThrowsWhenNotImplemented()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\FnStream(array());
        $stream->seek(1);
    }
    public function testProxiesToFunction()
    {
        $self = $this;
        $s = new \TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\FnStream(array('read' => function ($len) use($self) {
            $self->assertEquals(3, $len);
            return 'foo';
        }));
        $this->assertEquals('foo', $s->read(3));
    }
    public function testCanCloseOnDestruct()
    {
        $called = \false;
        $s = new \TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\FnStream(array('close' => function () use(&$called) {
            $called = \true;
        }));
        unset($s);
        $this->assertTrue($called);
    }
    public function testDoesNotRequireClose()
    {
        $s = new \TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\FnStream(array());
        unset($s);
    }
    public function testDecoratesStream()
    {
        $a = \TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\stream_for('foo');
        $b = \TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\FnStream::decorate($a, array());
        $this->assertEquals(3, $b->getSize());
        $this->assertEquals($b->isWritable(), \true);
        $this->assertEquals($b->isReadable(), \true);
        $this->assertEquals($b->isSeekable(), \true);
        $this->assertEquals($b->read(3), 'foo');
        $this->assertEquals($b->tell(), 3);
        $this->assertEquals($a->tell(), 3);
        $this->assertSame('', $a->read(1));
        $this->assertEquals($b->eof(), \true);
        $this->assertEquals($a->eof(), \true);
        $b->seek(0);
        $this->assertEquals('foo', (string) $b);
        $b->seek(0);
        $this->assertEquals('foo', $b->getContents());
        $this->assertEquals($a->getMetadata(), $b->getMetadata());
        $b->seek(0, \SEEK_END);
        $b->write('bar');
        $this->assertEquals('foobar', (string) $b);
        $this->assertInternalType('resource', $b->detach());
        $b->close();
    }
    public function testDecoratesWithCustomizations()
    {
        $called = \false;
        $a = \TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\stream_for('foo');
        $b = \TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\FnStream::decorate($a, array('read' => function ($len) use(&$called, $a) {
            $called = \true;
            return $a->read($len);
        }));
        $this->assertEquals('foo', $b->read(3));
        $this->assertTrue($called);
    }
}
