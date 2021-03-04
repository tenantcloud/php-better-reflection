<?php

namespace TenantCloud\BetterReflection\Relocated\InstanceOfNamespace;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
interface BarInterface
{
}
abstract class BarParent
{
}
class Foo extends \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\BarParent
{
    public function someMethod(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $foo)
    {
        $bar = $foo;
        $baz = doFoo();
        $intersected = new \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\Foo();
        $parent = doFoo();
        if ($baz instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\Foo) {
            // ...
        } else {
            while ($foo instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch) {
                \assert($lorem instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\Lorem);
                if ($dolor instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\Dolor && $sit instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\Sit) {
                    if ($static instanceof static) {
                        if ($self instanceof self) {
                            if ($intersected instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\BarInterface) {
                                if ($this instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\BarInterface) {
                                    if ($parent instanceof parent) {
                                        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PhpParser\\Node\\Expr\\ArrayDimFetch', $foo);
                                        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PhpParser\\Node\\Expr', $bar);
                                        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*ERROR*', $baz);
                                        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\Lorem', $lorem);
                                        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\Dolor', $dolor);
                                        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\Sit', $sit);
                                        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\Foo', $self);
                                        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('static(InstanceOfNamespace\\Foo)', $static);
                                        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('static(InstanceOfNamespace\\Foo)', clone $static);
                                        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\BarInterface&InstanceOfNamespace\\Foo', $intersected);
                                        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\$this(InstanceOfNamespace\\Foo)&InstanceOfNamespace\\BarInterface', $this);
                                        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\BarParent', $parent);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    /**
     * @template ObjectT of BarInterface
     * @template MixedT
     *
     * @param class-string<Foo> $classString
     * @param class-string<Foo>|class-string<BarInterface> $union
     * @param class-string<Foo>&class-string<BarInterface> $intersection
     * @param BarInterface $instance
     * @param ObjectT $objectT
     * @param class-string<ObjectT> $objectTString
     * @param class-string<MixedT> $mixedTString
     * @param object $object
     */
    public function testExprInstanceof($subject, string $classString, $union, $intersection, string $other, $instance, $objectT, $objectTString, $mixedTString, string $string, $object)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $subject instanceof $classString);
        if ($subject instanceof $classString) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\Foo', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $subject instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\Foo);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $subject instanceof $classString);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\mixed~InstanceOfNamespace\\Foo', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $subject instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\Foo);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $subject instanceof $classString);
        }
        $constantString = 'TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\BarParent';
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $subject instanceof $constantString);
        if ($subject instanceof $constantString) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\BarParent', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $subject instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\BarParent);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $subject instanceof $constantString);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\mixed~InstanceOfNamespace\\BarParent', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $subject instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\BarParent);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $subject instanceof $constantString);
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $subject instanceof $union);
        if ($subject instanceof $union) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\BarInterface|InstanceOfNamespace\\Foo', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $subject instanceof $union);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $subject instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\BarInterface);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $subject instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\Foo);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $subject instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\Foo || $subject instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\BarInterface);
        }
        if ($subject instanceof $intersection) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\BarInterface&InstanceOfNamespace\\Foo', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $subject instanceof $intersection);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $subject instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\BarInterface);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $subject instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\Foo);
        }
        if ($subject instanceof $instance) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\BarInterface', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $subject instanceof $instance);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $subject instanceof \TenantCloud\BetterReflection\Relocated\InstanceOfNamespace\BarInterface);
        }
        if ($subject instanceof $other) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $subject instanceof $other);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $subject instanceof $other);
        }
        if ($subject instanceof $objectT) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('ObjectT of InstanceOfNamespace\\BarInterface (method InstanceOfNamespace\\Foo::testExprInstanceof(), argument)', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $subject instanceof $objectT);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~ObjectT of InstanceOfNamespace\\BarInterface (method InstanceOfNamespace\\Foo::testExprInstanceof(), argument)', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $subject instanceof $objectT);
        }
        if ($subject instanceof $objectTString) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('ObjectT of InstanceOfNamespace\\BarInterface (method InstanceOfNamespace\\Foo::testExprInstanceof(), argument)', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $subject instanceof $objectTString);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~ObjectT of InstanceOfNamespace\\BarInterface (method InstanceOfNamespace\\Foo::testExprInstanceof(), argument)', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $subject instanceof $objectTString);
        }
        if ($subject instanceof $mixedTString) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('MixedT (method InstanceOfNamespace\\Foo::testExprInstanceof(), argument)&object', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $subject instanceof $mixedTString);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~MixedT (method InstanceOfNamespace\\Foo::testExprInstanceof(), argument)', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $subject instanceof $mixedTString);
        }
        if ($subject instanceof $string) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $subject instanceof $string);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $subject);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $subject instanceof $string);
        }
        if ($object instanceof $string) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object', $object);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $object instanceof $string);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object', $object);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $object instanceof $string);
        }
        if ($object instanceof $object) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object', $object);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $object instanceof $object);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object', $object);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $object instanceof $object);
        }
        if ($object instanceof $classString) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\Foo', $object);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $object instanceof $classString);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\object~InstanceOfNamespace\\Foo', $object);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $object instanceof $classString);
        }
        if ($instance instanceof $string) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\BarInterface', $instance);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $instance instanceof $string);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\BarInterface', $instance);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $instance instanceof $string);
        }
        if ($instance instanceof $object) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\BarInterface', $instance);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $instance instanceof $object);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\BarInterface', $instance);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $object instanceof $object);
        }
        if ($instance instanceof $classString) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\BarInterface&InstanceOfNamespace\\Foo', $instance);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $instance instanceof $classString);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\InstanceOfNamespace\\BarInterface', $instance);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $instance instanceof $classString);
        }
    }
}
