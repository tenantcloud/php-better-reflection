<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2850;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function y() : void
    {
    }
}
class Bar
{
    /** @var Foo|null */
    private $x;
    public function getFoo() : \TenantCloud\BetterReflection\Relocated\Bug2850\Foo
    {
        if ($this->x === null) {
            $this->x = new \TenantCloud\BetterReflection\Relocated\Bug2850\Foo();
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\Bug2850\Foo::class, $this->x);
            $this->x->y();
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\Bug2850\Foo::class, $this->x);
            $this->y();
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\Bug2850\Foo::class . '|null', $this->x);
        }
        return $this->x;
    }
    public function y() : void
    {
        $this->x = null;
    }
}
