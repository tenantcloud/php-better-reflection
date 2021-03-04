<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase;
use TenantCloud\BetterReflection\Relocated\TestDirectorySourceLocator\AFoo;
class OptimizedDirectorySourceLocatorTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataClass() : array
    {
        return [[\TenantCloud\BetterReflection\Relocated\TestDirectorySourceLocator\AFoo::class, \TenantCloud\BetterReflection\Relocated\TestDirectorySourceLocator\AFoo::class, 'a.php'], ['TenantCloud\\BetterReflection\\Relocated\\testdirectorySourceLocator\\aFoo', \TenantCloud\BetterReflection\Relocated\TestDirectorySourceLocator\AFoo::class, 'a.php'], [\TenantCloud\BetterReflection\Relocated\BFoo::class, \TenantCloud\BetterReflection\Relocated\BFoo::class, 'b.php'], ['bfOO', \TenantCloud\BetterReflection\Relocated\BFoo::class, 'b.php']];
    }
    /**
     * @dataProvider dataClass
     * @param string $className
     * @param string $file
     */
    public function testClass(string $className, string $expectedClassName, string $file) : void
    {
        $factory = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorFactory::class);
        $locator = $factory->createByDirectory(__DIR__ . '/data/directory');
        $classReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector($locator);
        $classReflection = $classReflector->reflect($className);
        $this->assertSame($expectedClassName, $classReflection->getName());
        $this->assertNotNull($classReflection->getFileName());
        $this->assertSame($file, \basename($classReflection->getFileName()));
    }
    public function dataFunctionExists() : array
    {
        return [['TenantCloud\\BetterReflection\\Relocated\\TestDirectorySourceLocator\\doLorem', 'TenantCloud\\BetterReflection\\Relocated\\TestDirectorySourceLocator\\doLorem', 'a.php'], ['TenantCloud\\BetterReflection\\Relocated\\testdirectorysourcelocator\\doLorem', 'TenantCloud\\BetterReflection\\Relocated\\TestDirectorySourceLocator\\doLorem', 'a.php'], ['doBar', 'doBar', 'b.php'], ['doBaz', 'doBaz', 'b.php'], ['dobaz', 'doBaz', 'b.php'], ['get_smarty', 'get_smarty', 'b.php'], ['get_smarty2', 'get_smarty2', 'b.php']];
    }
    /**
     * @dataProvider dataFunctionExists
     * @param string $functionName
     * @param string $expectedFunctionName
     * @param string $file
     */
    public function testFunctionExists(string $functionName, string $expectedFunctionName, string $file) : void
    {
        $factory = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorFactory::class);
        $locator = $factory->createByDirectory(__DIR__ . '/data/directory');
        $classReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector($locator);
        $functionReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector($locator, $classReflector);
        $functionReflection = $functionReflector->reflect($functionName);
        $this->assertSame($expectedFunctionName, $functionReflection->getName());
        $this->assertNotNull($functionReflection->getFileName());
        $this->assertSame($file, \basename($functionReflection->getFileName()));
    }
    public function dataFunctionDoesNotExist() : array
    {
        return [['doFoo'], ['TenantCloud\\BetterReflection\\Relocated\\TestDirectorySourceLocator\\doFoo']];
    }
    /**
     * @dataProvider dataFunctionDoesNotExist
     * @param string $functionName
     */
    public function testFunctionDoesNotExist(string $functionName) : void
    {
        $factory = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorFactory::class);
        $locator = $factory->createByDirectory(__DIR__ . '/data/directory');
        $classReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector($locator);
        $functionReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector($locator, $classReflector);
        $this->expectException(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound::class);
        $functionReflector->reflect($functionName);
    }
}
