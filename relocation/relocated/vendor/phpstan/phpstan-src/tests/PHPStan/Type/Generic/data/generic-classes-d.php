<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Test\D;

/** @template T */
interface Invariant
{
    /** @return T */
    public function get();
}
/** @template-covariant T */
interface Out
{
    /** @return T */
    public function get();
}
