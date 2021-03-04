<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Roave\SignatureTest;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\Base64Encoder;
use TenantCloud\BetterReflection\Relocated\Roave\Signature\FileContentSigner;
/**
 * @covers \Roave\Signature\FileContentSigner
 */
final class FileContentSignerTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @return string[][]
     */
    public function signProvider() : array
    {
        return [['Roave/Signature: PD9waHA=', '<?php'], ['Roave/Signature: PD9waHAK', '<?php' . "\n"], ['Roave/Signature: PGh0bWw+', '<html>'], ['Roave/Signature: cGxhaW4gdGV4dA==', 'plain text']];
    }
    /**
     * @dataProvider signProvider
     */
    public function testSign(string $expected, string $inputString) : void
    {
        $signer = new \TenantCloud\BetterReflection\Relocated\Roave\Signature\FileContentSigner(new \TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\Base64Encoder());
        self::assertSame($expected, $signer->sign($inputString));
    }
}
