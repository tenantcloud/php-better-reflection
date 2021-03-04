<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Roave\SignatureTest;

use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\Base64Encoder;
use TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\EncoderInterface;
use TenantCloud\BetterReflection\Relocated\Roave\Signature\FileContentChecker;
/**
 * @covers \Roave\Signature\FileContentChecker
 */
final class FileContentCheckerTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @var EncoderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $encoder;
    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->encoder = $this->createMock(\TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\EncoderInterface::class);
    }
    public function testShouldCheckClassFileContent()
    {
        $classFilePath = __DIR__ . '/../../fixture/UserClassSignedByFileContent.php';
        self::assertFileExists($classFilePath);
        $checker = new \TenantCloud\BetterReflection\Relocated\Roave\Signature\FileContentChecker(new \TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\Base64Encoder());
        $checker->check(\file_get_contents($classFilePath));
    }
    public function testShouldReturnFalseIfSignatureDoesNotMatch()
    {
        $classFilePath = __DIR__ . '/../../fixture/UserClassSignedByFileContent.php';
        self::assertFileExists($classFilePath);
        $expectedSignature = 'YToxOntpOjA7czoxNDE6Ijw/cGhwCgpuYW1lc3BhY2UgU2lnbmF0dXJlVGVzdEZpeHR1cmU7' . 'CgpjbGFzcyBVc2VyQ2xhc3NTaWduZWRCeUZpbGVDb250ZW50CnsKICAgIHB1YmxpYyAkbmFtZTsKCiAgICBwcm90ZW' . 'N0ZWQgJHN1cm5hbWU7CgogICAgcHJpdmF0ZSAkYWdlOwp9CiI7fQ==';
        $this->encoder->expects(self::once())->method('verify')->with(\str_replace('/** Roave/Signature: ' . $expectedSignature . ' */' . "\n", '', \file_get_contents($classFilePath)), $expectedSignature);
        $checker = new \TenantCloud\BetterReflection\Relocated\Roave\Signature\FileContentChecker($this->encoder);
        self::assertFalse($checker->check(\file_get_contents($classFilePath)));
    }
    public function testShouldReturnFalseIfClassIsNotSigned()
    {
        $classFilePath = __DIR__ . '/../../fixture/UserClass.php';
        self::assertFileExists($classFilePath);
        $checker = new \TenantCloud\BetterReflection\Relocated\Roave\Signature\FileContentChecker($this->encoder);
        self::assertFalse($checker->check(\file_get_contents($classFilePath)));
    }
}
