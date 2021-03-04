<?php

namespace TenantCloud\BetterReflection\Relocated\AnnotationsProperties;

use TenantCloud\BetterReflection\Relocated\OtherNamespace\Test as OtherTest;
use TenantCloud\BetterReflection\Relocated\OtherNamespace\Ipsum;
/**
 * @property OtherTest $otherTest
 * @property-read Ipsum $otherTestReadOnly
 * @property self|Bar $fooOrBar
 * @property Ipsum $conflictingProperty
 * @property Foo $overridenProperty
 */
class Foo implements \TenantCloud\BetterReflection\Relocated\AnnotationsProperties\FooInterface
{
    /** @var Foo */
    public $overridenPropertyWithAnnotation;
}
/**
 * @property Bar $overridenPropertyWithAnnotation
 * @property Foo $conflictingAnnotationProperty
 */
class Bar extends \TenantCloud\BetterReflection\Relocated\AnnotationsProperties\Foo
{
    /** @var Bar */
    public $overridenProperty;
    /** @var Bar */
    public $conflictingAnnotationProperty;
}
/**
 * @property   Lorem  $bazProperty
 * @property Dolor $conflictingProperty
 * @property-write ?Lorem $writeOnlyProperty
 */
class Baz extends \TenantCloud\BetterReflection\Relocated\AnnotationsProperties\Bar
{
    use FooTrait;
}
/**
 * @property int | float $numericBazBazProperty
 */
class BazBaz extends \TenantCloud\BetterReflection\Relocated\AnnotationsProperties\Baz
{
}
/**
 * @property FooInterface $interfaceProperty
 */
interface FooInterface
{
}
/**
 * @property BazBaz $traitProperty
 */
trait FooTrait
{
}
