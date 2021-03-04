<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\NativeStaticReturnType\Foo;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType;
class StaticTypeTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function testMixedType() : void
    {
        if (\PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 8.0');
        }
        $reflectionProvider = $this->createBroker();
        $class = $reflectionProvider->getClass(\TenantCloud\BetterReflection\Relocated\NativeStaticReturnType\Foo::class);
        $method = $class->getNativeMethod('doFoo');
        $methodVariant = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants());
        $methodReturnType = $methodVariant->getReturnType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType::class, $methodReturnType);
        $this->assertSame(\TenantCloud\BetterReflection\Relocated\NativeStaticReturnType\Foo::class, $methodReturnType->getClassName());
    }
}
