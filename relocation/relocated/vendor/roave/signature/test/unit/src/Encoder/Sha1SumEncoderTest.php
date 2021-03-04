<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Roave\SignatureTest\Encoder;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\Sha1SumEncoder;
/**
 * @covers \Roave\Signature\Encoder\Sha1SumEncoder
 */
final class Sha1SumEncoderTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testEncode()
    {
        $value = \uniqid('values', \true);
        self::assertSame(\sha1($value), (new \TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\Sha1SumEncoder())->encode($value));
    }
    public function testVerify()
    {
        $value = \uniqid('values', \true);
        self::assertTrue((new \TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\Sha1SumEncoder())->verify($value, \sha1($value)));
    }
}
