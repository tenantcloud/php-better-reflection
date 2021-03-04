<?php

namespace TenantCloud\BetterReflection\Relocated\RingCentral\Tests\Psr7;

use TenantCloud\BetterReflection\Relocated\RingCentral\Psr7;
use TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\InflateStream;
function php53_gzencode($data)
{
    return \gzdeflate($data);
}
class InflateStreamtest extends \TenantCloud\BetterReflection\Relocated\PHPUnit_Framework_TestCase
{
    public function testInflatesStreams()
    {
        $content = \gzencode('test');
        $a = \TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\stream_for($content);
        $b = new \TenantCloud\BetterReflection\Relocated\RingCentral\Psr7\InflateStream($a);
        $this->assertEquals('test', (string) $b);
    }
}
