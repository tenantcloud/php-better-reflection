<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
class UnionTypeMethodReflectionTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function testCollectsDeprecatedMessages() : void
    {
        $reflection = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnionTypeMethodReflection('foo', [$this->createDeprecatedMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), 'Deprecated'), $this->createDeprecatedMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), 'Maybe deprecated'), $this->createDeprecatedMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), 'Not deprecated')]);
        $this->assertSame('Deprecated', $reflection->getDeprecatedDescription());
    }
    public function testMultipleDeprecationsAreJoined() : void
    {
        $reflection = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnionTypeMethodReflection('foo', [$this->createDeprecatedMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), 'Deprecated #1'), $this->createDeprecatedMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), 'Deprecated #2')]);
        $this->assertSame('Deprecated #1 Deprecated #2', $reflection->getDeprecatedDescription());
    }
    private function createDeprecatedMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $deprecated, ?string $deprecationText) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        $method = $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection::class);
        $method->method('isDeprecated')->willReturn($deprecated);
        $method->method('getDeprecatedDescription')->willReturn($deprecationText);
        return $method;
    }
}
