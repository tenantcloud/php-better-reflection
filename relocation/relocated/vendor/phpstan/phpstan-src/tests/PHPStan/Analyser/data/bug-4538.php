<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4538;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param string $index
     */
    public function bar(string $index) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string|false', \getenv($index));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>', \getenv());
    }
}
