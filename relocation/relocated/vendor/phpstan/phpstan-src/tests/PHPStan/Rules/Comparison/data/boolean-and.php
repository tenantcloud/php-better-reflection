<?php

namespace TenantCloud\BetterReflection\Relocated\ConstantCondition;

class BooleanAnd
{
    public function doFoo(int $i, bool $j, \stdClass $std, ?\stdClass $nullableStd)
    {
        if ($i && $j) {
        }
        $one = 1;
        if ($one && $i) {
        }
        if ($i && $std) {
        }
        $zero = 0;
        if ($zero && $i) {
        }
        if ($i && $zero) {
        }
        if ($one === 0 && $one) {
        }
        if ($one === 1 && $one) {
        }
        if ($nullableStd && $nullableStd) {
        }
        if ($nullableStd !== null && $nullableStd) {
        }
    }
    /**
     * @param Foo|Bar $union
     * @param Lorem&Ipsum $intersection
     */
    public function checkUnionAndIntersection($union, $intersection)
    {
        if ($union instanceof \TenantCloud\BetterReflection\Relocated\ConstantCondition\Foo && $union instanceof \TenantCloud\BetterReflection\Relocated\ConstantCondition\Bar) {
        }
        if ($intersection instanceof \TenantCloud\BetterReflection\Relocated\ConstantCondition\Lorem && $intersection instanceof \TenantCloud\BetterReflection\Relocated\ConstantCondition\Ipsum) {
        }
        if ($union instanceof \TenantCloud\BetterReflection\Relocated\ConstantCondition\Foo || $union instanceof \TenantCloud\BetterReflection\Relocated\ConstantCondition\Bar) {
        } elseif ($union instanceof \TenantCloud\BetterReflection\Relocated\ConstantCondition\Foo && doFoo()) {
        }
        if ($intersection instanceof \TenantCloud\BetterReflection\Relocated\ConstantCondition\Lorem && $intersection instanceof \TenantCloud\BetterReflection\Relocated\ConstantCondition\Ipsum) {
        } elseif ($intersection instanceof \TenantCloud\BetterReflection\Relocated\ConstantCondition\Lorem && doFoo()) {
        }
    }
}
class NonNullablePropertiesShouldNotReportError
{
    /** @var self */
    private $foo;
    /** @var self */
    private $bar;
    public function doFoo()
    {
        if ($this->foo !== null && $this->bar !== null) {
        }
    }
}
class StringInIsset
{
    public function doFoo(string $s, string $t)
    {
        if (isset($s[1]) && isset($t[1])) {
        }
    }
}
class IssetBug
{
    public function doFoo(string $alias, array $options = [])
    {
        list($name, $p) = \explode('.', $alias);
        if (isset($options['c']) && !\strpos($options['c'], '\\')) {
            // ...
        }
        if (!isset($options['c']) && \strpos($p, 'X') === 0) {
            // ?
        }
    }
}
class IntegerRangeType
{
    public function doFoo(int $i, float $f)
    {
        if ($i < 3 && $i > 5) {
            // can never happen
        }
        if ($f > 0 && $f < 1) {
        }
    }
}
class AndInIfCondition
{
    public function andInIfCondition($mixed, int $i) : void
    {
        if (!$mixed) {
            if ($mixed && $i) {
            }
            if ($i && $mixed) {
            }
        }
        if ($mixed) {
            if ($mixed && $i) {
            }
            if ($i && $mixed) {
            }
        }
    }
}
function getMaybeArray() : ?array
{
    if (\rand(0, 1)) {
        return [1, 2, 3];
    }
    return null;
}
function bug1924()
{
    $arr = ['a' => getMaybeArray(), 'b' => getMaybeArray()];
    if (isset($arr['a']) && isset($arr['b'])) {
    }
}
