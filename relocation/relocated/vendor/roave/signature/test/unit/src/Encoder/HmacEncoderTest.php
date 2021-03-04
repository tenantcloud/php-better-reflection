<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Roave\SignatureTest\Encoder;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\HmacEncoder;
/**
 * @covers \Roave\Signature\Encoder\HmacEncoder
 */
final class HmacEncoderTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testEncode()
    {
        $hmacKey = \random_bytes(64);
        $value = \uniqid('values', \true);
        self::assertSame(\hash_hmac('sha256', $value, $hmacKey), (new \TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\HmacEncoder($hmacKey))->encode($value));
    }
    public function testVerify()
    {
        $hmacKey = \random_bytes(64);
        $value = \uniqid('values', \true);
        self::assertTrue((new \TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\HmacEncoder($hmacKey))->verify($value, \hash_hmac('sha256', $value, $hmacKey)));
    }
}
