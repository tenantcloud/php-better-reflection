<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\PromotedPropertiesTypes;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @template T
 */
class Foo
{
    /**
     * @param array<int, string> $anotherPhpDocArray
     * @param T $anotherTemplateProperty
     * @param string $bothProperty
     * @param array<string> $anotherBothProperty
     */
    public function __construct(
        public $noType,
        public int $nativeIntType,
        /** @var array<int, string> */
        public $phpDocArray,
        public $anotherPhpDocArray,
        /** @var array<int, string> */
        public array $yetAnotherPhpDocArray,
        /** @var T */
        public $templateProperty,
        public $anotherTemplateProperty,
        /** @var int */
        public $bothProperty,
        /** @var array<int> */
        public $anotherBothProperty
    )
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', $phpDocArray);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $phpDocArray);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', $anotherPhpDocArray);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $anotherPhpDocArray);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', $yetAnotherPhpDocArray);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('array', $yetAnotherPhpDocArray);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $bothProperty);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int>', $anotherBothProperty);
    }
}
function (\TenantCloud\BetterReflection\Relocated\PromotedPropertiesTypes\Foo $foo) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $foo->noType);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $foo->nativeIntType);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', $foo->phpDocArray);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', $foo->anotherPhpDocArray);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', $foo->yetAnotherPhpDocArray);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $foo->bothProperty);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int>', $foo->anotherBothProperty);
};
/**
 * @extends Foo<\stdClass>
 */
class Bar extends \TenantCloud\BetterReflection\Relocated\PromotedPropertiesTypes\Foo
{
}
function (\TenantCloud\BetterReflection\Relocated\PromotedPropertiesTypes\Bar $bar) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $bar->templateProperty);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $bar->anotherTemplateProperty);
};
/**
 * @template T
 */
class Lorem
{
    /**
     * @param T $foo
     */
    public function __construct(public $foo)
    {
    }
}
function () : void {
    $lorem = new \TenantCloud\BetterReflection\Relocated\PromotedPropertiesTypes\Lorem(new \stdClass());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $lorem->foo);
};
/**
 * @extends Foo<\stdClass>
 */
class Baz extends \TenantCloud\BetterReflection\Relocated\PromotedPropertiesTypes\Foo
{
    public function __construct(public $anotherPhpDocArray)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', $anotherPhpDocArray);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $anotherPhpDocArray);
    }
}
function (\TenantCloud\BetterReflection\Relocated\PromotedPropertiesTypes\Baz $baz) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', $baz->anotherPhpDocArray);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $baz->templateProperty);
};
