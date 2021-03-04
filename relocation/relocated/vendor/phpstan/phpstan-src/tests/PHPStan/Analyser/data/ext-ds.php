<?php

namespace TenantCloud\BetterReflection\Relocated\ExtDs;

use Ds\Map;
use Ds\Set;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class A
{
}
class B
{
}
class Foo
{
    /** @param Map<int, int> $a */
    public function mapGet(\Ds\Map $a) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $a->get(1));
    }
    /** @param Map<int, int> $a */
    public function mapGetWithDefaultValue(\Ds\Map $a) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|null', $a->get(1, null));
    }
    /** @param Map<int, int|string> $a */
    public function mapGetUnionType(\Ds\Map $a) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|string', $a->get(1));
    }
    /** @param Map<int, int|string> $a */
    public function mapGetUnionTypeWithDefaultValue(\Ds\Map $a) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|string|null', $a->get(1, null));
    }
    /** @param Map<int, int|string> $a */
    public function mapRemoveUnionType(\Ds\Map $a) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|string', $a->remove(1));
    }
    /** @param Map<int, int|string> $a */
    public function mapRemoveUnionTypeWithDefaultValue(\Ds\Map $a) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|string|null', $a->remove(1, null));
    }
    public function mapMerge() : void
    {
        $a = new \Ds\Map([1 => new \TenantCloud\BetterReflection\Relocated\ExtDs\A()]);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Ds\\Map<int|string, ExtDs\\A|ExtDs\\B>', $a->merge(['a' => new \TenantCloud\BetterReflection\Relocated\ExtDs\B()]));
    }
    public function mapUnion() : void
    {
        $a = new \Ds\Map([1 => new \TenantCloud\BetterReflection\Relocated\ExtDs\A()]);
        $b = new \Ds\Map(['a' => new \TenantCloud\BetterReflection\Relocated\ExtDs\B()]);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Ds\\Map<int|string, ExtDs\\A|ExtDs\\B>', $a->union($b));
    }
    public function mapXor() : void
    {
        $a = new \Ds\Map([1 => new \TenantCloud\BetterReflection\Relocated\ExtDs\A()]);
        $b = new \Ds\Map(['a' => new \TenantCloud\BetterReflection\Relocated\ExtDs\B()]);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Ds\\Map<int|string, ExtDs\\A|ExtDs\\B>', $a->xor($b));
    }
    public function setMerge() : void
    {
        $a = new \Ds\Set([new \TenantCloud\BetterReflection\Relocated\ExtDs\A()]);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Ds\\Set<ExtDs\\A|ExtDs\\B>', $a->merge([new \TenantCloud\BetterReflection\Relocated\ExtDs\B()]));
    }
    public function setUnion() : void
    {
        $a = new \Ds\Set([new \TenantCloud\BetterReflection\Relocated\ExtDs\A()]);
        $b = new \Ds\Set([new \TenantCloud\BetterReflection\Relocated\ExtDs\B()]);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Ds\\Set<ExtDs\\A|ExtDs\\B>', $a->union($b));
    }
    public function setXor() : void
    {
        $a = new \Ds\Set([new \TenantCloud\BetterReflection\Relocated\ExtDs\A()]);
        $b = new \Ds\Set([new \TenantCloud\BetterReflection\Relocated\ExtDs\B()]);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Ds\\Set<ExtDs\\A|ExtDs\\B>', $a->xor($b));
    }
}
/**
 * @implements \IteratorAggregate<int, int>
 * @implements \Ds\Collection<int, int>
 */
abstract class Bar implements \IteratorAggregate, \Ds\Collection
{
    public function doFoo()
    {
        foreach ($this as $key => $val) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $key);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $val);
        }
    }
}
