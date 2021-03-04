<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayItem;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
class LiteralArrayItem
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope;
    private ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayItem $arrayItem;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayItem $arrayItem)
    {
        $this->scope = $scope;
        $this->arrayItem = $arrayItem;
    }
    public function getScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getArrayItem() : ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayItem
    {
        return $this->arrayItem;
    }
}
