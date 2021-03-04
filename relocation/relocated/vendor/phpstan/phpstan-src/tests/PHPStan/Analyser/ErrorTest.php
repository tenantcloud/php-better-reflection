<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

class ErrorTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function testError() : void
    {
        $error = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Error('Message', 'file', 10);
        $this->assertSame('Message', $error->getMessage());
        $this->assertSame('file', $error->getFile());
        $this->assertSame(10, $error->getLine());
    }
}
