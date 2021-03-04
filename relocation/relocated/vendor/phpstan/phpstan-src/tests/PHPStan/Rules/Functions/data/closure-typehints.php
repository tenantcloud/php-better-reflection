<?php

namespace TenantCloud\BetterReflection\Relocated\TestClosureFunctionTypehints;

class FooFunctionTypehints
{
}
$callback = function (\TenantCloud\BetterReflection\Relocated\TestClosureFunctionTypehints\FooFunctionTypehints $foo, $bar, array $lorem) : NonexistentClass {
};
$callback = function (\TenantCloud\BetterReflection\Relocated\TestClosureFunctionTypehints\BarFunctionTypehints $bar) : array {
};
$callback = function (...$bar) : FooFunctionTypehints {
};
$callback = function () : parent {
};
$callback = function (\TenantCloud\BetterReflection\Relocated\TestClosureFunctionTypehints\fOOfUnctionTypehints $foo) : FOOfUnctionTypehintS {
};
$callback = function (\TenantCloud\BetterReflection\Relocated\ReturnTypes\FooAliaS $ignoreAlias) {
};
trait SomeTrait
{
}
$callback = function (\TenantCloud\BetterReflection\Relocated\TestClosureFunctionTypehints\SomeTrait $trait) {
};
$callback = function () : SomeTrait {
};
