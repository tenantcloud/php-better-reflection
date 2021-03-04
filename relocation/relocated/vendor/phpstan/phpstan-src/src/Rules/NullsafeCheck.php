<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
class NullsafeCheck
{
    public function containsNullSafe(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\NullsafePropertyFetch || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\NullsafeMethodCall) {
            return \true;
        }
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch) {
            return $this->containsNullSafe($expr->var);
        }
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch) {
            return $this->containsNullSafe($expr->var);
        }
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch && $expr->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr) {
            return $this->containsNullSafe($expr->class);
        }
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall) {
            return $this->containsNullSafe($expr->var);
        }
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall && $expr->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr) {
            return $this->containsNullSafe($expr->class);
        }
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\List_ || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Array_) {
            foreach ($expr->items as $item) {
                if ($item === null) {
                    continue;
                }
                if ($item->key !== null && $this->containsNullSafe($item->key)) {
                    return \true;
                }
                if ($this->containsNullSafe($item->value)) {
                    return \true;
                }
            }
        }
        return \false;
    }
}
