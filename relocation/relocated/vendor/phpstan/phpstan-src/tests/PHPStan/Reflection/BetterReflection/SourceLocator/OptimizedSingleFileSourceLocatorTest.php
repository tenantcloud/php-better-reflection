<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase;
use TenantCloud\BetterReflection\Relocated\TestSingleFileSourceLocator\AFoo;
class OptimizedSingleFileSourceLocatorTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataClass() : array
    {
        return [[\TenantCloud\BetterReflection\Relocated\TestSingleFileSourceLocator\AFoo::class, \TenantCloud\BetterReflection\Relocated\TestSingleFileSourceLocator\AFoo::class, __DIR__ . '/data/a.php'], ['TenantCloud\\BetterReflection\\Relocated\\testSinglefileSourceLocator\\afoo', \TenantCloud\BetterReflection\Relocated\TestSingleFileSourceLocator\AFoo::class, __DIR__ . '/data/a.php'], [\TenantCloud\BetterReflection\Relocated\SingleFileSourceLocatorTestClass::class, \TenantCloud\BetterReflection\Relocated\SingleFileSourceLocatorTestClass::class, __DIR__ . '/data/b.php'], ['SinglefilesourceLocatortestClass', \TenantCloud\BetterReflection\Relocated\SingleFileSourceLocatorTestClass::class, __DIR__ . '/data/b.php']];
    }
    /**
     * @dataProvider dataClass
     * @param string $className
     * @param string $expectedClassName
     * @param string $file
     */
    public function testClass(string $className, string $expectedClassName, string $file) : void
    {
        $factory = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorFactory::class);
        $locator = $factory->create($file);
        $classReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector($locator);
        $classReflection = $classReflector->reflect($className);
        $this->assertSame($expectedClassName, $classReflection->getName());
    }
    public function dataFunction() : array
    {
        return [['TenantCloud\\BetterReflection\\Relocated\\TestSingleFileSourceLocator\\doFoo', 'TenantCloud\\BetterReflection\\Relocated\\TestSingleFileSourceLocator\\doFoo', __DIR__ . '/data/a.php'], ['TenantCloud\\BetterReflection\\Relocated\\testSingleFilesourcelocatOR\\dofoo', 'TenantCloud\\BetterReflection\\Relocated\\TestSingleFileSourceLocator\\doFoo', __DIR__ . '/data/a.php'], ['singleFileSourceLocatorTestFunction', 'singleFileSourceLocatorTestFunction', __DIR__ . '/data/b.php'], ['singlefileSourceLocatORTestfunCTion', 'singleFileSourceLocatorTestFunction', __DIR__ . '/data/b.php']];
    }
    /**
     * @dataProvider dataFunction
     * @param string $functionName
     * @param string $expectedFunctionName
     * @param string $file
     */
    public function testFunction(string $functionName, string $expectedFunctionName, string $file) : void
    {
        $factory = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorFactory::class);
        $locator = $factory->create($file);
        $classReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector($locator);
        $functionReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector($locator, $classReflector);
        $functionReflection = $functionReflector->reflect($functionName);
        $this->assertSame($expectedFunctionName, $functionReflection->getName());
    }
    public function dataConst() : array
    {
        return [['TenantCloud\\BetterReflection\\Relocated\\ConstFile\\TABLE_NAME', 'resized_images'], ['ANOTHER_NAME', 'foo_images'], ['TenantCloud\\BetterReflection\\Relocated\\ConstFile\\ANOTHER_NAME', 'bar_images'], ['const_with_dir_const', \str_replace('\\', '/', __DIR__ . '/data')]];
    }
    /**
     * @dataProvider dataConst
     * @param string $constantName
     * @param mixed $value
     */
    public function testConst(string $constantName, $value) : void
    {
        $factory = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorFactory::class);
        $locator = $factory->create(__DIR__ . '/data/const.php');
        $classReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector($locator);
        $constantReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector($locator, $classReflector);
        $constant = $constantReflector->reflect($constantName);
        $this->assertSame($constantName, $constant->getName());
        $this->assertSame($value, $constant->getValue());
    }
    public function dataConstUnknown() : array
    {
        return [['TEST_VARIABLE']];
    }
    /**
     * @dataProvider dataConstUnknown
     * @param string $constantName
     */
    public function testConstUnknown(string $constantName) : void
    {
        $factory = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorFactory::class);
        $locator = $factory->create(__DIR__ . '/data/const.php');
        $classReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector($locator);
        $constantReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector($locator, $classReflector);
        $this->expectException(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound::class);
        $constantReflector->reflect($constantName);
    }
}
