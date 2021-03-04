<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\NativeMixedType\Foo;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
class MixedTypeTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function testMixedType() : void
    {
        if (\PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 8.0');
        }
        $reflectionProvider = $this->createBroker();
        $class = $reflectionProvider->getClass(\TenantCloud\BetterReflection\Relocated\NativeMixedType\Foo::class);
        $propertyType = $class->getNativeProperty('fooProp')->getNativeType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType::class, $propertyType);
        $this->assertTrue($propertyType->isExplicitMixed());
        $method = $class->getNativeMethod('doFoo');
        $methodVariant = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants());
        $methodReturnType = $methodVariant->getReturnType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType::class, $methodReturnType);
        $this->assertTrue($methodReturnType->isExplicitMixed());
        $methodParameterType = $methodVariant->getParameters()[0]->getType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType::class, $methodParameterType);
        $this->assertTrue($methodParameterType->isExplicitMixed());
        $function = $reflectionProvider->getFunction(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name('TenantCloud\\BetterReflection\\Relocated\\NativeMixedType\\doFoo'), null);
        $functionVariant = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($function->getVariants());
        $functionReturnType = $functionVariant->getReturnType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType::class, $functionReturnType);
        $this->assertTrue($functionReturnType->isExplicitMixed());
        $functionParameterType = $functionVariant->getParameters()[0]->getType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType::class, $functionParameterType);
        $this->assertTrue($functionParameterType->isExplicitMixed());
    }
}
