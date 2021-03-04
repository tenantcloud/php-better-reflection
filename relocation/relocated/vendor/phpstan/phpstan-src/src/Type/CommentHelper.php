<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
/** @deprecated */
class CommentHelper
{
    public static function getDocComment(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node) : ?string
    {
        $phpDoc = $node->getDocComment();
        if ($phpDoc !== null) {
            return $phpDoc->getText();
        }
        return null;
    }
}
