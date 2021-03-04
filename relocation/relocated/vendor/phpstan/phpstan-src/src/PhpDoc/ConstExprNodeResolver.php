<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class ConstExprNodeResolver
{
    public function resolve(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $node) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode) {
            return $this->resolveArrayNode($node);
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper::getTypeFromValue(\false);
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper::getTypeFromValue(\true);
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper::getTypeFromValue((float) $node->value);
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper::getTypeFromValue((int) $node->value);
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper::getTypeFromValue(null);
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper::getTypeFromValue($node->value);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
    }
    private function resolveArrayNode(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode $node) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType
    {
        $arrayBuilder = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
        foreach ($node->items as $item) {
            if ($item->key === null) {
                $key = null;
            } else {
                $key = $this->resolve($item->key);
            }
            $arrayBuilder->setOffsetValueType($key, $this->resolve($item->value));
        }
        return $arrayBuilder->getArray();
    }
}
