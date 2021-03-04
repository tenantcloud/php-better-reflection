<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Bug4552;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
interface OptionPresenter
{
}
/**
 * @template TPresenter of OptionPresenter
 */
interface OptionDefinition
{
    /**
     * @return TPresenter
     */
    public function presenter();
}
class SimpleOptionPresenter implements \TenantCloud\BetterReflection\Relocated\Bug4552\OptionPresenter
{
    public function test() : bool
    {
    }
}
/**
 * @template-implements OptionDefinition<SimpleOptionPresenter>
 */
class SimpleOptionDefinition implements \TenantCloud\BetterReflection\Relocated\Bug4552\OptionDefinition
{
    public function presenter()
    {
        return new \TenantCloud\BetterReflection\Relocated\Bug4552\SimpleOptionPresenter();
    }
}
/**
 * @template T of OptionPresenter
 *
 * @param class-string<OptionDefinition<T>> $definition
 *
 * @return T
 */
function present($definition)
{
    return instantiate($definition)->presenter();
}
/**
 * @template T of OptionDefinition
 *
 * @param class-string<T> $definition
 *
 * @return T
 */
function instantiate($definition)
{
    return new $definition();
}
function () : void {
    $p = present(\TenantCloud\BetterReflection\Relocated\Bug4552\SimpleOptionDefinition::class);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\Bug4552\SimpleOptionPresenter::class, $p);
    $p->test();
};
