<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2869;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param array<string, string|null> $bar
     */
    public function doFoo(array $bar) : void
    {
        if (\array_key_exists('foo', $bar)) {
            $foobar = isset($bar['foo']);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $foobar);
        }
    }
    /**
     * @param array<string, string> $bar
     */
    public function doBar(array $bar) : void
    {
        if (\array_key_exists('foo', $bar)) {
            $foobar = isset($bar['foo']);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $foobar);
        }
    }
}
