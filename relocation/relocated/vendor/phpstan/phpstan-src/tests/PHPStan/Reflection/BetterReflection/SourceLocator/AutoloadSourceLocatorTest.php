<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase;
use TenantCloud\BetterReflection\Relocated\TestSingleFileSourceLocator\AFoo;
use TenantCloud\BetterReflection\Relocated\TestSingleFileSourceLocator\InCondition;
function testFunctionForLocator() : void
{
}
class AutoloadSourceLocatorTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function testAutoloadEverythingInFile() : void
    {
        /** @var FunctionReflector $functionReflector */
        $functionReflector = null;
        $locator = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher::class));
        $classReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector($locator);
        $functionReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector($locator, $classReflector);
        $constantReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector($locator, $classReflector);
        $aFoo = $classReflector->reflect(\TenantCloud\BetterReflection\Relocated\TestSingleFileSourceLocator\AFoo::class);
        $this->assertNotNull($aFoo->getFileName());
        $this->assertSame('a.php', \basename($aFoo->getFileName()));
        $testFunctionReflection = $functionReflector->reflect('TenantCloud\\BetterReflection\\Relocated\\PHPStan\\Reflection\\BetterReflection\\SourceLocator\\testFunctionForLocator');
        $this->assertSame(\str_replace('\\', '/', __FILE__), $testFunctionReflection->getFileName());
        $someConstant = $constantReflector->reflect('TenantCloud\\BetterReflection\\Relocated\\TestSingleFileSourceLocator\\SOME_CONSTANT');
        $this->assertNotNull($someConstant->getFileName());
        $this->assertSame('a.php', \basename($someConstant->getFileName()));
        $this->assertSame(1, $someConstant->getValue());
        $anotherConstant = $constantReflector->reflect('TenantCloud\\BetterReflection\\Relocated\\TestSingleFileSourceLocator\\ANOTHER_CONSTANT');
        $this->assertNotNull($anotherConstant->getFileName());
        $this->assertSame('a.php', \basename($anotherConstant->getFileName()));
        $this->assertSame(2, $anotherConstant->getValue());
        $doFooFunctionReflection = $functionReflector->reflect('TenantCloud\\BetterReflection\\Relocated\\TestSingleFileSourceLocator\\doFoo');
        $this->assertSame('TenantCloud\\BetterReflection\\Relocated\\TestSingleFileSourceLocator\\doFoo', $doFooFunctionReflection->getName());
        $this->assertNotNull($doFooFunctionReflection->getFileName());
        $this->assertSame('a.php', \basename($doFooFunctionReflection->getFileName()));
        \class_exists(\TenantCloud\BetterReflection\Relocated\TestSingleFileSourceLocator\InCondition::class);
        $classInCondition = $classReflector->reflect(\TenantCloud\BetterReflection\Relocated\TestSingleFileSourceLocator\InCondition::class);
        $classInConditionFilename = $classInCondition->getFileName();
        $this->assertNotNull($classInConditionFilename);
        $this->assertSame('a.php', \basename($classInConditionFilename));
        $this->assertSame(\TenantCloud\BetterReflection\Relocated\TestSingleFileSourceLocator\InCondition::class, $classInCondition->getName());
        $this->assertSame(25, $classInCondition->getStartLine());
        $this->assertInstanceOf(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass::class, $classInCondition->getParentClass());
        $this->assertSame(\TenantCloud\BetterReflection\Relocated\TestSingleFileSourceLocator\AFoo::class, $classInCondition->getParentClass()->getName());
    }
}
