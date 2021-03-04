<?php

namespace TenantCloud\BetterReflection\Relocated\Bug1233;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class HelloWorld
{
    public function toArray($value) : array
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $value);
        if (\is_array($value)) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array', $value);
            return $value;
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~array', $value);
        if (\is_iterable($value)) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Traversable<mixed, mixed>', $value);
            return \iterator_to_array($value);
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~array', $value);
        throw new \LogicException();
    }
}
