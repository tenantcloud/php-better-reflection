<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class ThrowsAnnotationsTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataThrowsAnnotations() : array
    {
        return [[\TenantCloud\BetterReflection\Relocated\ThrowsAnnotations\Foo::class, ['withoutThrows' => null, 'throwsRuntime' => \RuntimeException::class, 'staticThrowsRuntime' => \RuntimeException::class]], [\TenantCloud\BetterReflection\Relocated\ThrowsAnnotations\PhpstanFoo::class, ['withoutThrows' => 'void', 'throwsRuntime' => \RuntimeException::class, 'staticThrowsRuntime' => \RuntimeException::class]], [\TenantCloud\BetterReflection\Relocated\ThrowsAnnotations\FooInterface::class, ['withoutThrows' => null, 'throwsRuntime' => \RuntimeException::class, 'staticThrowsRuntime' => \RuntimeException::class]], [\TenantCloud\BetterReflection\Relocated\ThrowsAnnotations\FooTrait::class, ['withoutThrows' => null, 'throwsRuntime' => \RuntimeException::class, 'staticThrowsRuntime' => \RuntimeException::class]], [\TenantCloud\BetterReflection\Relocated\ThrowsAnnotations\BarTrait::class, ['withoutThrows' => null, 'throwsRuntime' => \RuntimeException::class, 'staticThrowsRuntime' => \RuntimeException::class]]];
    }
    /**
     * @dataProvider dataThrowsAnnotations
     * @param string $className
     * @param array<string, mixed> $throwsAnnotations
     */
    public function testThrowsAnnotations(string $className, array $throwsAnnotations) : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::class);
        $class = $broker->getClass($className);
        $scope = $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope::class);
        foreach ($throwsAnnotations as $methodName => $type) {
            $methodAnnotation = $class->getMethod($methodName, $scope);
            $throwType = $methodAnnotation->getThrowType();
            $this->assertSame($type, $throwType !== null ? $throwType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()) : null);
        }
    }
    public function testThrowsOnUserFunctions() : void
    {
        require_once __DIR__ . '/data/annotations-throws.php';
        /** @var Broker $broker */
        $broker = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::class);
        $this->assertNull($broker->getFunction(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name\FullyQualified('TenantCloud\\BetterReflection\\Relocated\\ThrowsAnnotations\\withoutThrows'), null)->getThrowType());
        $throwType = $broker->getFunction(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name\FullyQualified('TenantCloud\\BetterReflection\\Relocated\\ThrowsAnnotations\\throwsRuntime'), null)->getThrowType();
        $this->assertNotNull($throwType);
        $this->assertSame(\RuntimeException::class, $throwType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()));
    }
    public function testThrowsOnNativeFunctions() : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::class);
        $this->assertNull($broker->getFunction(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name('str_replace'), null)->getThrowType());
        $this->assertNull($broker->getFunction(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name('get_class'), null)->getThrowType());
        $this->assertNull($broker->getFunction(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name('function_exists'), null)->getThrowType());
    }
}
