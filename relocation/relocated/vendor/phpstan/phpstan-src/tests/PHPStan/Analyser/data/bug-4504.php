<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4504TypeInference;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function sayHello($models) : void
    {
        /** @var \Iterator<A> $models */
        foreach ($models as $k => $v) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug4504TypeInference\\A', $v);
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array()|Iterator<mixed, Bug4504TypeInference\\A>', $models);
    }
}
