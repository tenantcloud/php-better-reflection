<?php

namespace TenantCloud\BetterReflection\Relocated\Bug1216;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
abstract class Foo
{
    /**
     * @var int
     */
    protected $foo;
}
trait Bar
{
    /**
     * @var int
     */
    protected $bar;
    protected $untypedBar;
}
/**
 * @property string $foo
 * @property string $bar
 * @property string $untypedBar
 */
class Baz extends \TenantCloud\BetterReflection\Relocated\Bug1216\Foo
{
    public function __construct()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $this->foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $this->bar);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $this->untypedBar);
    }
}
function (\TenantCloud\BetterReflection\Relocated\Bug1216\Baz $baz) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $baz->foo);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $baz->bar);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $baz->untypedBar);
};
