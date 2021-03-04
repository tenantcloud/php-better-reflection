<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
class InternalAnnotationsTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataInternalAnnotations() : array
    {
        return [[\false, \TenantCloud\BetterReflection\Relocated\InternalAnnotations\Foo::class, ['constant' => ['FOO'], 'method' => ['foo', 'staticFoo'], 'property' => ['foo', 'staticFoo']]], [\true, \TenantCloud\BetterReflection\Relocated\InternalAnnotations\InternalFoo::class, ['constant' => ['INTERNAL_FOO'], 'method' => ['internalFoo', 'internalStaticFoo'], 'property' => ['internalFoo', 'internalStaticFoo']]], [\false, \TenantCloud\BetterReflection\Relocated\InternalAnnotations\FooInterface::class, ['constant' => ['FOO'], 'method' => ['foo', 'staticFoo']]], [\true, \TenantCloud\BetterReflection\Relocated\InternalAnnotations\InternalFooInterface::class, ['constant' => ['INTERNAL_FOO'], 'method' => ['internalFoo', 'internalStaticFoo']]], [\false, \TenantCloud\BetterReflection\Relocated\InternalAnnotations\FooTrait::class, ['method' => ['foo', 'staticFoo'], 'property' => ['foo', 'staticFoo']]], [\true, \TenantCloud\BetterReflection\Relocated\InternalAnnotations\InternalFooTrait::class, ['method' => ['internalFoo', 'internalStaticFoo'], 'property' => ['internalFoo', 'internalStaticFoo']]]];
    }
    /**
     * @dataProvider dataInternalAnnotations
     * @param bool $internal
     * @param string $className
     * @param array<string, mixed> $internalAnnotations
     */
    public function testInternalAnnotations(bool $internal, string $className, array $internalAnnotations) : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::class);
        $class = $broker->getClass($className);
        $scope = $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope::class);
        $scope->method('isInClass')->willReturn(\true);
        $scope->method('getClassReflection')->willReturn($class);
        $scope->method('canAccessProperty')->willReturn(\true);
        $this->assertSame($internal, $class->isInternal());
        foreach ($internalAnnotations['method'] ?? [] as $methodName) {
            $methodAnnotation = $class->getMethod($methodName, $scope);
            $this->assertSame($internal, $methodAnnotation->isInternal()->yes());
        }
        foreach ($internalAnnotations['property'] ?? [] as $propertyName) {
            $propertyAnnotation = $class->getProperty($propertyName, $scope);
            $this->assertSame($internal, $propertyAnnotation->isInternal()->yes());
        }
        foreach ($internalAnnotations['constant'] ?? [] as $constantName) {
            $constantAnnotation = $class->getConstant($constantName);
            $this->assertSame($internal, $constantAnnotation->isInternal()->yes());
        }
    }
    public function testInternalUserFunctions() : void
    {
        require_once __DIR__ . '/data/annotations-internal.php';
        /** @var Broker $broker */
        $broker = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::class);
        $this->assertFalse($broker->getFunction(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name\FullyQualified('TenantCloud\\BetterReflection\\Relocated\\InternalAnnotations\\foo'), null)->isInternal()->yes());
        $this->assertTrue($broker->getFunction(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name\FullyQualified('TenantCloud\\BetterReflection\\Relocated\\InternalAnnotations\\internalFoo'), null)->isInternal()->yes());
    }
}
