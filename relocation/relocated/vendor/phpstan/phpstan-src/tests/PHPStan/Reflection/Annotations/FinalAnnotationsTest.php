<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
class FinalAnnotationsTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataFinalAnnotations() : array
    {
        return [[\false, \TenantCloud\BetterReflection\Relocated\FinalAnnotations\Foo::class, ['method' => ['foo', 'staticFoo']]], [\true, \TenantCloud\BetterReflection\Relocated\FinalAnnotations\FinalFoo::class, ['method' => ['finalFoo', 'finalStaticFoo']]]];
    }
    /**
     * @dataProvider dataFinalAnnotations
     * @param bool $final
     * @param string $className
     * @param array<string, mixed> $finalAnnotations
     */
    public function testFinalAnnotations(bool $final, string $className, array $finalAnnotations) : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::class);
        $class = $broker->getClass($className);
        $scope = $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope::class);
        $scope->method('isInClass')->willReturn(\true);
        $scope->method('getClassReflection')->willReturn($class);
        $scope->method('canAccessProperty')->willReturn(\true);
        $this->assertSame($final, $class->isFinal());
        foreach ($finalAnnotations['method'] ?? [] as $methodName) {
            $methodAnnotation = $class->getMethod($methodName, $scope);
            $this->assertSame($final, $methodAnnotation->isFinal()->yes());
        }
    }
    public function testFinalUserFunctions() : void
    {
        require_once __DIR__ . '/data/annotations-final.php';
        /** @var Broker $broker */
        $broker = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::class);
        $this->assertFalse($broker->getFunction(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name\FullyQualified('TenantCloud\\BetterReflection\\Relocated\\FinalAnnotations\\foo'), null)->isFinal()->yes());
        $this->assertTrue($broker->getFunction(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name\FullyQualified('TenantCloud\\BetterReflection\\Relocated\\FinalAnnotations\\finalFoo'), null)->isFinal()->yes());
    }
}
