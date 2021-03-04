<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Roave\SignatureTest\Encoder;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\Base64Encoder;
/**
 * @covers \Roave\Signature\Encoder\Base64Encoder
 */
final class Base64EncoderTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function testEncode()
    {
        $encoder = new \TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\Base64Encoder();
        self::assertSame('IA==', $encoder->encode(' '));
        self::assertSame('PD9waHA=', $encoder->encode('<?php'));
    }
    public function testVerify()
    {
        $value = \uniqid('values', \true);
        self::assertTrue((new \TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\Base64Encoder())->verify($value, \base64_encode($value)));
    }
}
