<?php

namespace TenantCloud\BetterReflection\Relocated\ClassPhpDocsNamespace;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @method string string()
 * @method array arrayOfStrings()
 * @psalm-method array<string> arrayOfStrings()
 * @phpstan-method array<string, int> arrayOfInts()
 * @method array arrayOfInts()
 * @method mixed overrodeMethod()
 * @method static mixed overrodeStaticMethod()
 */
class Foo
{
    public function __call($name, $arguments)
    {
    }
    public static function __callStatic($name, $arguments)
    {
    }
    public function doFoo()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $this->string());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>', $this->arrayOfStrings());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string, int>', $this->arrayOfInts());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $this->overrodeMethod());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', static::overrodeStaticMethod());
    }
}
/**
 * @phpstan-method string overrodeMethod()
 * @phpstan-method static int overrodeStaticMethod()
 */
class Child extends \TenantCloud\BetterReflection\Relocated\ClassPhpDocsNamespace\Foo
{
    public function doFoo()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $this->overrodeMethod());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', static::overrodeStaticMethod());
    }
}
