<?php

namespace TenantCloud\BetterReflection\Relocated\EmptyArrayInProperty;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /** @var string[] */
    private $comments;
    public function doFoo() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>', $this->comments);
        $this->comments = [];
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array()', $this->comments);
        if ($this->comments === []) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array()', $this->comments);
            return;
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $this->comments);
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $this->comments);
    }
    public function doBar() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>', $this->comments);
        $this->comments = [];
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array()', $this->comments);
        if ([] === $this->comments) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array()', $this->comments);
            return;
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $this->comments);
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $this->comments);
    }
}
