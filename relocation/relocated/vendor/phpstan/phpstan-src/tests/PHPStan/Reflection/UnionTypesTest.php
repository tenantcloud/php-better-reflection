<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\NativeUnionTypes\Foo;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class UnionTypesTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function testUnionTypes() : void
    {
        if (\PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 8.0');
        }
        require_once __DIR__ . '/../../../stubs/runtime/ReflectionUnionType.php';
        $reflectionProvider = $this->createBroker();
        $class = $reflectionProvider->getClass(\TenantCloud\BetterReflection\Relocated\NativeUnionTypes\Foo::class);
        $propertyType = $class->getNativeProperty('fooProp')->getNativeType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType::class, $propertyType);
        $this->assertSame('bool|int', $propertyType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $method = $class->getNativeMethod('doFoo');
        $methodVariant = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants());
        $methodReturnType = $methodVariant->getReturnType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType::class, $methodReturnType);
        $this->assertSame('TenantCloud\\BetterReflection\\Relocated\\NativeUnionTypes\\Bar|NativeUnionTypes\\Foo', $methodReturnType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $methodParameterType = $methodVariant->getParameters()[0]->getType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType::class, $methodParameterType);
        $this->assertSame('bool|int', $methodParameterType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $function = $reflectionProvider->getFunction(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name('TenantCloud\\BetterReflection\\Relocated\\NativeUnionTypes\\doFoo'), null);
        $functionVariant = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($function->getVariants());
        $functionReturnType = $functionVariant->getReturnType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType::class, $functionReturnType);
        $this->assertSame('TenantCloud\\BetterReflection\\Relocated\\NativeUnionTypes\\Bar|NativeUnionTypes\\Foo', $functionReturnType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $functionParameterType = $functionVariant->getParameters()[0]->getType();
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType::class, $functionParameterType);
        $this->assertSame('bool|int', $functionParameterType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
    }
}
