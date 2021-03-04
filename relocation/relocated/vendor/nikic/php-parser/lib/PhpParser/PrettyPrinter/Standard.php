<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt;
use TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinterAbstract;
class Standard extends \TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinterAbstract
{
    // Special nodes
    protected function pParam(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Param $node)
    {
        return $this->pAttrGroups($node->attrGroups, \true) . $this->pModifiers($node->flags) . ($node->type ? $this->p($node->type) . ' ' : '') . ($node->byRef ? '&' : '') . ($node->variadic ? '...' : '') . $this->p($node->var) . ($node->default ? ' = ' . $this->p($node->default) : '');
    }
    protected function pArg(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Arg $node)
    {
        return ($node->name ? $node->name->toString() . ': ' : '') . ($node->byRef ? '&' : '') . ($node->unpack ? '...' : '') . $this->p($node->value);
    }
    protected function pConst(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Const_ $node)
    {
        return $node->name . ' = ' . $this->p($node->value);
    }
    protected function pNullableType(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\NullableType $node)
    {
        return '?' . $this->p($node->type);
    }
    protected function pUnionType(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\UnionType $node)
    {
        return $this->pImplode($node->types, '|');
    }
    protected function pIdentifier(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier $node)
    {
        return $node->name;
    }
    protected function pVarLikeIdentifier(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\VarLikeIdentifier $node)
    {
        return '$' . $node->name;
    }
    protected function pAttribute(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Attribute $node)
    {
        return $this->p($node->name) . ($node->args ? '(' . $this->pCommaSeparated($node->args) . ')' : '');
    }
    protected function pAttributeGroup(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\AttributeGroup $node)
    {
        return '#[' . $this->pCommaSeparated($node->attrs) . ']';
    }
    // Names
    protected function pName(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $node)
    {
        return \implode('\\', $node->parts);
    }
    protected function pName_FullyQualified(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name\FullyQualified $node)
    {
        return '\\' . \implode('\\', $node->parts);
    }
    protected function pName_Relative(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name\Relative $node)
    {
        return 'namespace\\' . \implode('\\', $node->parts);
    }
    // Magic Constants
    protected function pScalar_MagicConst_Class(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst\Class_ $node)
    {
        return '__CLASS__';
    }
    protected function pScalar_MagicConst_Dir(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst\Dir $node)
    {
        return '__DIR__';
    }
    protected function pScalar_MagicConst_File(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst\File $node)
    {
        return '__FILE__';
    }
    protected function pScalar_MagicConst_Function(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst\Function_ $node)
    {
        return '__FUNCTION__';
    }
    protected function pScalar_MagicConst_Line(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst\Line $node)
    {
        return '__LINE__';
    }
    protected function pScalar_MagicConst_Method(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst\Method $node)
    {
        return '__METHOD__';
    }
    protected function pScalar_MagicConst_Namespace(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst\Namespace_ $node)
    {
        return '__NAMESPACE__';
    }
    protected function pScalar_MagicConst_Trait(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst\Trait_ $node)
    {
        return '__TRAIT__';
    }
    // Scalars
    protected function pScalar_String(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_ $node)
    {
        $kind = $node->getAttribute('kind', \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_::KIND_SINGLE_QUOTED);
        switch ($kind) {
            case \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_::KIND_NOWDOC:
                $label = $node->getAttribute('docLabel');
                if ($label && !$this->containsEndLabel($node->value, $label)) {
                    if ($node->value === '') {
                        return "<<<'{$label}'\n{$label}" . $this->docStringEndToken;
                    }
                    return "<<<'{$label}'\n{$node->value}\n{$label}" . $this->docStringEndToken;
                }
            /* break missing intentionally */
            case \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_::KIND_SINGLE_QUOTED:
                return $this->pSingleQuotedString($node->value);
            case \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_::KIND_HEREDOC:
                $label = $node->getAttribute('docLabel');
                if ($label && !$this->containsEndLabel($node->value, $label)) {
                    if ($node->value === '') {
                        return "<<<{$label}\n{$label}" . $this->docStringEndToken;
                    }
                    $escaped = $this->escapeString($node->value, null);
                    return "<<<{$label}\n" . $escaped . "\n{$label}" . $this->docStringEndToken;
                }
            /* break missing intentionally */
            case \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_::KIND_DOUBLE_QUOTED:
                return '"' . $this->escapeString($node->value, '"') . '"';
        }
        throw new \Exception('Invalid string kind');
    }
    protected function pScalar_Encapsed(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\Encapsed $node)
    {
        if ($node->getAttribute('kind') === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_::KIND_HEREDOC) {
            $label = $node->getAttribute('docLabel');
            if ($label && !$this->encapsedContainsEndLabel($node->parts, $label)) {
                if (\count($node->parts) === 1 && $node->parts[0] instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\EncapsedStringPart && $node->parts[0]->value === '') {
                    return "<<<{$label}\n{$label}" . $this->docStringEndToken;
                }
                return "<<<{$label}\n" . $this->pEncapsList($node->parts, null) . "\n{$label}" . $this->docStringEndToken;
            }
        }
        return '"' . $this->pEncapsList($node->parts, '"') . '"';
    }
    protected function pScalar_LNumber(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber $node)
    {
        if ($node->value === -\PHP_INT_MAX - 1) {
            // PHP_INT_MIN cannot be represented as a literal,
            // because the sign is not part of the literal
            return '(-' . \PHP_INT_MAX . '-1)';
        }
        $kind = $node->getAttribute('kind', \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber::KIND_DEC);
        if (\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber::KIND_DEC === $kind) {
            return (string) $node->value;
        }
        if ($node->value < 0) {
            $sign = '-';
            $str = (string) -$node->value;
        } else {
            $sign = '';
            $str = (string) $node->value;
        }
        switch ($kind) {
            case \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber::KIND_BIN:
                return $sign . '0b' . \base_convert($str, 10, 2);
            case \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber::KIND_OCT:
                return $sign . '0' . \base_convert($str, 10, 8);
            case \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber::KIND_HEX:
                return $sign . '0x' . \base_convert($str, 10, 16);
        }
        throw new \Exception('Invalid number kind');
    }
    protected function pScalar_DNumber(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\DNumber $node)
    {
        if (!\is_finite($node->value)) {
            if ($node->value === \INF) {
                return '\\INF';
            } elseif ($node->value === -\INF) {
                return '-\\INF';
            } else {
                return '\\NAN';
            }
        }
        // Try to find a short full-precision representation
        $stringValue = \sprintf('%.16G', $node->value);
        if ($node->value !== (double) $stringValue) {
            $stringValue = \sprintf('%.17G', $node->value);
        }
        // %G is locale dependent and there exists no locale-independent alternative. We don't want
        // mess with switching locales here, so let's assume that a comma is the only non-standard
        // decimal separator we may encounter...
        $stringValue = \str_replace(',', '.', $stringValue);
        // ensure that number is really printed as float
        return \preg_match('/^-?[0-9]+$/', $stringValue) ? $stringValue . '.0' : $stringValue;
    }
    protected function pScalar_EncapsedStringPart(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\EncapsedStringPart $node)
    {
        throw new \LogicException('Cannot directly print EncapsedStringPart');
    }
    // Assignments
    protected function pExpr_Assign(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Assign $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Assign::class, $node->var, ' = ', $node->expr);
    }
    protected function pExpr_AssignRef(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignRef $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignRef::class, $node->var, ' =& ', $node->expr);
    }
    protected function pExpr_AssignOp_Plus(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Plus $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Plus::class, $node->var, ' += ', $node->expr);
    }
    protected function pExpr_AssignOp_Minus(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Minus $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Minus::class, $node->var, ' -= ', $node->expr);
    }
    protected function pExpr_AssignOp_Mul(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Mul $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Mul::class, $node->var, ' *= ', $node->expr);
    }
    protected function pExpr_AssignOp_Div(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Div $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Div::class, $node->var, ' /= ', $node->expr);
    }
    protected function pExpr_AssignOp_Concat(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Concat $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Concat::class, $node->var, ' .= ', $node->expr);
    }
    protected function pExpr_AssignOp_Mod(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Mod $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Mod::class, $node->var, ' %= ', $node->expr);
    }
    protected function pExpr_AssignOp_BitwiseAnd(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\BitwiseAnd $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\BitwiseAnd::class, $node->var, ' &= ', $node->expr);
    }
    protected function pExpr_AssignOp_BitwiseOr(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\BitwiseOr $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\BitwiseOr::class, $node->var, ' |= ', $node->expr);
    }
    protected function pExpr_AssignOp_BitwiseXor(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\BitwiseXor $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\BitwiseXor::class, $node->var, ' ^= ', $node->expr);
    }
    protected function pExpr_AssignOp_ShiftLeft(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\ShiftLeft $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\ShiftLeft::class, $node->var, ' <<= ', $node->expr);
    }
    protected function pExpr_AssignOp_ShiftRight(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\ShiftRight $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\ShiftRight::class, $node->var, ' >>= ', $node->expr);
    }
    protected function pExpr_AssignOp_Pow(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Pow $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Pow::class, $node->var, ' **= ', $node->expr);
    }
    protected function pExpr_AssignOp_Coalesce(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Coalesce $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Coalesce::class, $node->var, ' ??= ', $node->expr);
    }
    // Binary expressions
    protected function pExpr_BinaryOp_Plus(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Plus $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Plus::class, $node->left, ' + ', $node->right);
    }
    protected function pExpr_BinaryOp_Minus(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Minus $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Minus::class, $node->left, ' - ', $node->right);
    }
    protected function pExpr_BinaryOp_Mul(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Mul $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Mul::class, $node->left, ' * ', $node->right);
    }
    protected function pExpr_BinaryOp_Div(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Div $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Div::class, $node->left, ' / ', $node->right);
    }
    protected function pExpr_BinaryOp_Concat(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Concat $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Concat::class, $node->left, ' . ', $node->right);
    }
    protected function pExpr_BinaryOp_Mod(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Mod $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Mod::class, $node->left, ' % ', $node->right);
    }
    protected function pExpr_BinaryOp_BooleanAnd(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BooleanAnd $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BooleanAnd::class, $node->left, ' && ', $node->right);
    }
    protected function pExpr_BinaryOp_BooleanOr(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BooleanOr $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BooleanOr::class, $node->left, ' || ', $node->right);
    }
    protected function pExpr_BinaryOp_BitwiseAnd(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BitwiseAnd $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BitwiseAnd::class, $node->left, ' & ', $node->right);
    }
    protected function pExpr_BinaryOp_BitwiseOr(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BitwiseOr $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BitwiseOr::class, $node->left, ' | ', $node->right);
    }
    protected function pExpr_BinaryOp_BitwiseXor(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BitwiseXor $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BitwiseXor::class, $node->left, ' ^ ', $node->right);
    }
    protected function pExpr_BinaryOp_ShiftLeft(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\ShiftLeft $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\ShiftLeft::class, $node->left, ' << ', $node->right);
    }
    protected function pExpr_BinaryOp_ShiftRight(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\ShiftRight $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\ShiftRight::class, $node->left, ' >> ', $node->right);
    }
    protected function pExpr_BinaryOp_Pow(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Pow $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Pow::class, $node->left, ' ** ', $node->right);
    }
    protected function pExpr_BinaryOp_LogicalAnd(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\LogicalAnd $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\LogicalAnd::class, $node->left, ' and ', $node->right);
    }
    protected function pExpr_BinaryOp_LogicalOr(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\LogicalOr $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\LogicalOr::class, $node->left, ' or ', $node->right);
    }
    protected function pExpr_BinaryOp_LogicalXor(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\LogicalXor $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\LogicalXor::class, $node->left, ' xor ', $node->right);
    }
    protected function pExpr_BinaryOp_Equal(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Equal $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Equal::class, $node->left, ' == ', $node->right);
    }
    protected function pExpr_BinaryOp_NotEqual(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\NotEqual $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\NotEqual::class, $node->left, ' != ', $node->right);
    }
    protected function pExpr_BinaryOp_Identical(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Identical $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Identical::class, $node->left, ' === ', $node->right);
    }
    protected function pExpr_BinaryOp_NotIdentical(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\NotIdentical $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\NotIdentical::class, $node->left, ' !== ', $node->right);
    }
    protected function pExpr_BinaryOp_Spaceship(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Spaceship $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Spaceship::class, $node->left, ' <=> ', $node->right);
    }
    protected function pExpr_BinaryOp_Greater(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Greater $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Greater::class, $node->left, ' > ', $node->right);
    }
    protected function pExpr_BinaryOp_GreaterOrEqual(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual::class, $node->left, ' >= ', $node->right);
    }
    protected function pExpr_BinaryOp_Smaller(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Smaller $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Smaller::class, $node->left, ' < ', $node->right);
    }
    protected function pExpr_BinaryOp_SmallerOrEqual(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual::class, $node->left, ' <= ', $node->right);
    }
    protected function pExpr_BinaryOp_Coalesce(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Coalesce $node)
    {
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Coalesce::class, $node->left, ' ?? ', $node->right);
    }
    protected function pExpr_Instanceof(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Instanceof_ $node)
    {
        list($precedence, $associativity) = $this->precedenceMap[\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Instanceof_::class];
        return $this->pPrec($node->expr, $precedence, $associativity, -1) . ' instanceof ' . $this->pNewVariable($node->class);
    }
    // Unary expressions
    protected function pExpr_BooleanNot(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BooleanNot $node)
    {
        return $this->pPrefixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BooleanNot::class, '!', $node->expr);
    }
    protected function pExpr_BitwiseNot(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BitwiseNot $node)
    {
        return $this->pPrefixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BitwiseNot::class, '~', $node->expr);
    }
    protected function pExpr_UnaryMinus(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\UnaryMinus $node)
    {
        if ($node->expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\UnaryMinus || $node->expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PreDec) {
            // Enforce -(-$expr) instead of --$expr
            return '-(' . $this->p($node->expr) . ')';
        }
        return $this->pPrefixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\UnaryMinus::class, '-', $node->expr);
    }
    protected function pExpr_UnaryPlus(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\UnaryPlus $node)
    {
        if ($node->expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\UnaryPlus || $node->expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PreInc) {
            // Enforce +(+$expr) instead of ++$expr
            return '+(' . $this->p($node->expr) . ')';
        }
        return $this->pPrefixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\UnaryPlus::class, '+', $node->expr);
    }
    protected function pExpr_PreInc(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PreInc $node)
    {
        return $this->pPrefixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PreInc::class, '++', $node->var);
    }
    protected function pExpr_PreDec(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PreDec $node)
    {
        return $this->pPrefixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PreDec::class, '--', $node->var);
    }
    protected function pExpr_PostInc(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PostInc $node)
    {
        return $this->pPostfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PostInc::class, $node->var, '++');
    }
    protected function pExpr_PostDec(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PostDec $node)
    {
        return $this->pPostfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PostDec::class, $node->var, '--');
    }
    protected function pExpr_ErrorSuppress(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ErrorSuppress $node)
    {
        return $this->pPrefixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ErrorSuppress::class, '@', $node->expr);
    }
    protected function pExpr_YieldFrom(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\YieldFrom $node)
    {
        return $this->pPrefixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\YieldFrom::class, 'yield from ', $node->expr);
    }
    protected function pExpr_Print(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Print_ $node)
    {
        return $this->pPrefixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Print_::class, 'print ', $node->expr);
    }
    // Casts
    protected function pExpr_Cast_Int(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Int_ $node)
    {
        return $this->pPrefixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Int_::class, '(int) ', $node->expr);
    }
    protected function pExpr_Cast_Double(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Double $node)
    {
        $kind = $node->getAttribute('kind', \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Double::KIND_DOUBLE);
        if ($kind === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Double::KIND_DOUBLE) {
            $cast = '(double)';
        } elseif ($kind === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Double::KIND_FLOAT) {
            $cast = '(float)';
        } elseif ($kind === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Double::KIND_REAL) {
            $cast = '(real)';
        }
        return $this->pPrefixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Double::class, $cast . ' ', $node->expr);
    }
    protected function pExpr_Cast_String(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\String_ $node)
    {
        return $this->pPrefixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\String_::class, '(string) ', $node->expr);
    }
    protected function pExpr_Cast_Array(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Array_ $node)
    {
        return $this->pPrefixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Array_::class, '(array) ', $node->expr);
    }
    protected function pExpr_Cast_Object(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Object_ $node)
    {
        return $this->pPrefixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Object_::class, '(object) ', $node->expr);
    }
    protected function pExpr_Cast_Bool(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Bool_ $node)
    {
        return $this->pPrefixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Bool_::class, '(bool) ', $node->expr);
    }
    protected function pExpr_Cast_Unset(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Unset_ $node)
    {
        return $this->pPrefixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Unset_::class, '(unset) ', $node->expr);
    }
    // Function calls and similar constructs
    protected function pExpr_FuncCall(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $node)
    {
        return $this->pCallLhs($node->name) . '(' . $this->pMaybeMultiline($node->args) . ')';
    }
    protected function pExpr_MethodCall(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall $node)
    {
        return $this->pDereferenceLhs($node->var) . '->' . $this->pObjectProperty($node->name) . '(' . $this->pMaybeMultiline($node->args) . ')';
    }
    protected function pExpr_NullsafeMethodCall(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\NullsafeMethodCall $node)
    {
        return $this->pDereferenceLhs($node->var) . '?->' . $this->pObjectProperty($node->name) . '(' . $this->pMaybeMultiline($node->args) . ')';
    }
    protected function pExpr_StaticCall(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall $node)
    {
        return $this->pDereferenceLhs($node->class) . '::' . ($node->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr ? $node->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable ? $this->p($node->name) : '{' . $this->p($node->name) . '}' : $node->name) . '(' . $this->pMaybeMultiline($node->args) . ')';
    }
    protected function pExpr_Empty(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Empty_ $node)
    {
        return 'empty(' . $this->p($node->expr) . ')';
    }
    protected function pExpr_Isset(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Isset_ $node)
    {
        return 'isset(' . $this->pCommaSeparated($node->vars) . ')';
    }
    protected function pExpr_Eval(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Eval_ $node)
    {
        return 'eval(' . $this->p($node->expr) . ')';
    }
    protected function pExpr_Include(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Include_ $node)
    {
        static $map = [\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Include_::TYPE_INCLUDE => 'include', \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Include_::TYPE_INCLUDE_ONCE => 'include_once', \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Include_::TYPE_REQUIRE => 'require', \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Include_::TYPE_REQUIRE_ONCE => 'require_once'];
        return $map[$node->type] . ' ' . $this->p($node->expr);
    }
    protected function pExpr_List(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\List_ $node)
    {
        return 'list(' . $this->pCommaSeparated($node->items) . ')';
    }
    // Other
    protected function pExpr_Error(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Error $node)
    {
        throw new \LogicException('Cannot pretty-print AST with Error nodes');
    }
    protected function pExpr_Variable(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable $node)
    {
        if ($node->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr) {
            return '${' . $this->p($node->name) . '}';
        } else {
            return '$' . $node->name;
        }
    }
    protected function pExpr_Array(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Array_ $node)
    {
        $syntax = $node->getAttribute('kind', $this->options['shortArraySyntax'] ? \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Array_::KIND_SHORT : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Array_::KIND_LONG);
        if ($syntax === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Array_::KIND_SHORT) {
            return '[' . $this->pMaybeMultiline($node->items, \true) . ']';
        } else {
            return 'array(' . $this->pMaybeMultiline($node->items, \true) . ')';
        }
    }
    protected function pExpr_ArrayItem(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayItem $node)
    {
        return (null !== $node->key ? $this->p($node->key) . ' => ' : '') . ($node->byRef ? '&' : '') . ($node->unpack ? '...' : '') . $this->p($node->value);
    }
    protected function pExpr_ArrayDimFetch(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch $node)
    {
        return $this->pDereferenceLhs($node->var) . '[' . (null !== $node->dim ? $this->p($node->dim) : '') . ']';
    }
    protected function pExpr_ConstFetch(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ConstFetch $node)
    {
        return $this->p($node->name);
    }
    protected function pExpr_ClassConstFetch(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ClassConstFetch $node)
    {
        return $this->pDereferenceLhs($node->class) . '::' . $this->p($node->name);
    }
    protected function pExpr_PropertyFetch(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch $node)
    {
        return $this->pDereferenceLhs($node->var) . '->' . $this->pObjectProperty($node->name);
    }
    protected function pExpr_NullsafePropertyFetch(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\NullsafePropertyFetch $node)
    {
        return $this->pDereferenceLhs($node->var) . '?->' . $this->pObjectProperty($node->name);
    }
    protected function pExpr_StaticPropertyFetch(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch $node)
    {
        return $this->pDereferenceLhs($node->class) . '::$' . $this->pObjectProperty($node->name);
    }
    protected function pExpr_ShellExec(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ShellExec $node)
    {
        return '`' . $this->pEncapsList($node->parts, '`') . '`';
    }
    protected function pExpr_Closure(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Closure $node)
    {
        return $this->pAttrGroups($node->attrGroups, \true) . ($node->static ? 'static ' : '') . 'function ' . ($node->byRef ? '&' : '') . '(' . $this->pCommaSeparated($node->params) . ')' . (!empty($node->uses) ? ' use(' . $this->pCommaSeparated($node->uses) . ')' : '') . (null !== $node->returnType ? ' : ' . $this->p($node->returnType) : '') . ' {' . $this->pStmts($node->stmts) . $this->nl . '}';
    }
    protected function pExpr_Match(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Match_ $node)
    {
        return 'match (' . $this->p($node->cond) . ') {' . $this->pCommaSeparatedMultiline($node->arms, \true) . $this->nl . '}';
    }
    protected function pMatchArm(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\MatchArm $node)
    {
        return ($node->conds ? $this->pCommaSeparated($node->conds) : 'default') . ' => ' . $this->p($node->body);
    }
    protected function pExpr_ArrowFunction(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrowFunction $node)
    {
        return $this->pAttrGroups($node->attrGroups, \true) . ($node->static ? 'static ' : '') . 'fn' . ($node->byRef ? '&' : '') . '(' . $this->pCommaSeparated($node->params) . ')' . (null !== $node->returnType ? ': ' . $this->p($node->returnType) : '') . ' => ' . $this->p($node->expr);
    }
    protected function pExpr_ClosureUse(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ClosureUse $node)
    {
        return ($node->byRef ? '&' : '') . $this->p($node->var);
    }
    protected function pExpr_New(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\New_ $node)
    {
        if ($node->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_) {
            $args = $node->args ? '(' . $this->pMaybeMultiline($node->args) . ')' : '';
            return 'new ' . $this->pClassCommon($node->class, $args);
        }
        return 'new ' . $this->pNewVariable($node->class) . '(' . $this->pMaybeMultiline($node->args) . ')';
    }
    protected function pExpr_Clone(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Clone_ $node)
    {
        return 'clone ' . $this->p($node->expr);
    }
    protected function pExpr_Ternary(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Ternary $node)
    {
        // a bit of cheating: we treat the ternary as a binary op where the ?...: part is the operator.
        // this is okay because the part between ? and : never needs parentheses.
        return $this->pInfixOp(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Ternary::class, $node->cond, ' ?' . (null !== $node->if ? ' ' . $this->p($node->if) . ' ' : '') . ': ', $node->else);
    }
    protected function pExpr_Exit(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Exit_ $node)
    {
        $kind = $node->getAttribute('kind', \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Exit_::KIND_DIE);
        return ($kind === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Exit_::KIND_EXIT ? 'exit' : 'die') . (null !== $node->expr ? '(' . $this->p($node->expr) . ')' : '');
    }
    protected function pExpr_Throw(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Throw_ $node)
    {
        return 'throw ' . $this->p($node->expr);
    }
    protected function pExpr_Yield(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Yield_ $node)
    {
        if ($node->value === null) {
            return 'yield';
        } else {
            // this is a bit ugly, but currently there is no way to detect whether the parentheses are necessary
            return '(yield ' . ($node->key !== null ? $this->p($node->key) . ' => ' : '') . $this->p($node->value) . ')';
        }
    }
    // Declarations
    protected function pStmt_Namespace(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ $node)
    {
        if ($this->canUseSemicolonNamespaces) {
            return 'namespace ' . $this->p($node->name) . ';' . $this->nl . $this->pStmts($node->stmts, \false);
        } else {
            return 'namespace' . (null !== $node->name ? ' ' . $this->p($node->name) : '') . ' {' . $this->pStmts($node->stmts) . $this->nl . '}';
        }
    }
    protected function pStmt_Use(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_ $node)
    {
        return 'use ' . $this->pUseType($node->type) . $this->pCommaSeparated($node->uses) . ';';
    }
    protected function pStmt_GroupUse(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\GroupUse $node)
    {
        return 'use ' . $this->pUseType($node->type) . $this->pName($node->prefix) . '\\{' . $this->pCommaSeparated($node->uses) . '};';
    }
    protected function pStmt_UseUse(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\UseUse $node)
    {
        return $this->pUseType($node->type) . $this->p($node->name) . (null !== $node->alias ? ' as ' . $node->alias : '');
    }
    protected function pUseType($type)
    {
        return $type === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_::TYPE_FUNCTION ? 'function ' : ($type === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_::TYPE_CONSTANT ? 'const ' : '');
    }
    protected function pStmt_Interface(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Interface_ $node)
    {
        return $this->pAttrGroups($node->attrGroups) . 'interface ' . $node->name . (!empty($node->extends) ? ' extends ' . $this->pCommaSeparated($node->extends) : '') . $this->nl . '{' . $this->pStmts($node->stmts) . $this->nl . '}';
    }
    protected function pStmt_Class(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_ $node)
    {
        return $this->pClassCommon($node, ' ' . $node->name);
    }
    protected function pStmt_Trait(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Trait_ $node)
    {
        return $this->pAttrGroups($node->attrGroups) . 'trait ' . $node->name . $this->nl . '{' . $this->pStmts($node->stmts) . $this->nl . '}';
    }
    protected function pStmt_TraitUse(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\TraitUse $node)
    {
        return 'use ' . $this->pCommaSeparated($node->traits) . (empty($node->adaptations) ? ';' : ' {' . $this->pStmts($node->adaptations) . $this->nl . '}');
    }
    protected function pStmt_TraitUseAdaptation_Precedence(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\TraitUseAdaptation\Precedence $node)
    {
        return $this->p($node->trait) . '::' . $node->method . ' insteadof ' . $this->pCommaSeparated($node->insteadof) . ';';
    }
    protected function pStmt_TraitUseAdaptation_Alias(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\TraitUseAdaptation\Alias $node)
    {
        return (null !== $node->trait ? $this->p($node->trait) . '::' : '') . $node->method . ' as' . (null !== $node->newModifier ? ' ' . \rtrim($this->pModifiers($node->newModifier), ' ') : '') . (null !== $node->newName ? ' ' . $node->newName : '') . ';';
    }
    protected function pStmt_Property(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Property $node)
    {
        return $this->pAttrGroups($node->attrGroups) . (0 === $node->flags ? 'var ' : $this->pModifiers($node->flags)) . ($node->type ? $this->p($node->type) . ' ' : '') . $this->pCommaSeparated($node->props) . ';';
    }
    protected function pStmt_PropertyProperty(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\PropertyProperty $node)
    {
        return '$' . $node->name . (null !== $node->default ? ' = ' . $this->p($node->default) : '');
    }
    protected function pStmt_ClassMethod(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod $node)
    {
        return $this->pAttrGroups($node->attrGroups) . $this->pModifiers($node->flags) . 'function ' . ($node->byRef ? '&' : '') . $node->name . '(' . $this->pMaybeMultiline($node->params) . ')' . (null !== $node->returnType ? ' : ' . $this->p($node->returnType) : '') . (null !== $node->stmts ? $this->nl . '{' . $this->pStmts($node->stmts) . $this->nl . '}' : ';');
    }
    protected function pStmt_ClassConst(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassConst $node)
    {
        return $this->pAttrGroups($node->attrGroups) . $this->pModifiers($node->flags) . 'const ' . $this->pCommaSeparated($node->consts) . ';';
    }
    protected function pStmt_Function(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_ $node)
    {
        return $this->pAttrGroups($node->attrGroups) . 'function ' . ($node->byRef ? '&' : '') . $node->name . '(' . $this->pCommaSeparated($node->params) . ')' . (null !== $node->returnType ? ' : ' . $this->p($node->returnType) : '') . $this->nl . '{' . $this->pStmts($node->stmts) . $this->nl . '}';
    }
    protected function pStmt_Const(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Const_ $node)
    {
        return 'const ' . $this->pCommaSeparated($node->consts) . ';';
    }
    protected function pStmt_Declare(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Declare_ $node)
    {
        return 'declare (' . $this->pCommaSeparated($node->declares) . ')' . (null !== $node->stmts ? ' {' . $this->pStmts($node->stmts) . $this->nl . '}' : ';');
    }
    protected function pStmt_DeclareDeclare(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\DeclareDeclare $node)
    {
        return $node->key . '=' . $this->p($node->value);
    }
    // Control flow
    protected function pStmt_If(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\If_ $node)
    {
        return 'if (' . $this->p($node->cond) . ') {' . $this->pStmts($node->stmts) . $this->nl . '}' . ($node->elseifs ? ' ' . $this->pImplode($node->elseifs, ' ') : '') . (null !== $node->else ? ' ' . $this->p($node->else) : '');
    }
    protected function pStmt_ElseIf(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ElseIf_ $node)
    {
        return 'elseif (' . $this->p($node->cond) . ') {' . $this->pStmts($node->stmts) . $this->nl . '}';
    }
    protected function pStmt_Else(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Else_ $node)
    {
        return 'else {' . $this->pStmts($node->stmts) . $this->nl . '}';
    }
    protected function pStmt_For(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\For_ $node)
    {
        return 'for (' . $this->pCommaSeparated($node->init) . ';' . (!empty($node->cond) ? ' ' : '') . $this->pCommaSeparated($node->cond) . ';' . (!empty($node->loop) ? ' ' : '') . $this->pCommaSeparated($node->loop) . ') {' . $this->pStmts($node->stmts) . $this->nl . '}';
    }
    protected function pStmt_Foreach(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Foreach_ $node)
    {
        return 'foreach (' . $this->p($node->expr) . ' as ' . (null !== $node->keyVar ? $this->p($node->keyVar) . ' => ' : '') . ($node->byRef ? '&' : '') . $this->p($node->valueVar) . ') {' . $this->pStmts($node->stmts) . $this->nl . '}';
    }
    protected function pStmt_While(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\While_ $node)
    {
        return 'while (' . $this->p($node->cond) . ') {' . $this->pStmts($node->stmts) . $this->nl . '}';
    }
    protected function pStmt_Do(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Do_ $node)
    {
        return 'do {' . $this->pStmts($node->stmts) . $this->nl . '} while (' . $this->p($node->cond) . ');';
    }
    protected function pStmt_Switch(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Switch_ $node)
    {
        return 'switch (' . $this->p($node->cond) . ') {' . $this->pStmts($node->cases) . $this->nl . '}';
    }
    protected function pStmt_Case(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Case_ $node)
    {
        return (null !== $node->cond ? 'case ' . $this->p($node->cond) : 'default') . ':' . $this->pStmts($node->stmts);
    }
    protected function pStmt_TryCatch(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\TryCatch $node)
    {
        return 'try {' . $this->pStmts($node->stmts) . $this->nl . '}' . ($node->catches ? ' ' . $this->pImplode($node->catches, ' ') : '') . ($node->finally !== null ? ' ' . $this->p($node->finally) : '');
    }
    protected function pStmt_Catch(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Catch_ $node)
    {
        return 'catch (' . $this->pImplode($node->types, '|') . ($node->var !== null ? ' ' . $this->p($node->var) : '') . ') {' . $this->pStmts($node->stmts) . $this->nl . '}';
    }
    protected function pStmt_Finally(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Finally_ $node)
    {
        return 'finally {' . $this->pStmts($node->stmts) . $this->nl . '}';
    }
    protected function pStmt_Break(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Break_ $node)
    {
        return 'break' . ($node->num !== null ? ' ' . $this->p($node->num) : '') . ';';
    }
    protected function pStmt_Continue(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Continue_ $node)
    {
        return 'continue' . ($node->num !== null ? ' ' . $this->p($node->num) : '') . ';';
    }
    protected function pStmt_Return(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Return_ $node)
    {
        return 'return' . (null !== $node->expr ? ' ' . $this->p($node->expr) : '') . ';';
    }
    protected function pStmt_Throw(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Throw_ $node)
    {
        return 'throw ' . $this->p($node->expr) . ';';
    }
    protected function pStmt_Label(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Label $node)
    {
        return $node->name . ':';
    }
    protected function pStmt_Goto(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Goto_ $node)
    {
        return 'goto ' . $node->name . ';';
    }
    // Other
    protected function pStmt_Expression(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Expression $node)
    {
        return $this->p($node->expr) . ';';
    }
    protected function pStmt_Echo(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Echo_ $node)
    {
        return 'echo ' . $this->pCommaSeparated($node->exprs) . ';';
    }
    protected function pStmt_Static(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Static_ $node)
    {
        return 'static ' . $this->pCommaSeparated($node->vars) . ';';
    }
    protected function pStmt_Global(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Global_ $node)
    {
        return 'global ' . $this->pCommaSeparated($node->vars) . ';';
    }
    protected function pStmt_StaticVar(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\StaticVar $node)
    {
        return $this->p($node->var) . (null !== $node->default ? ' = ' . $this->p($node->default) : '');
    }
    protected function pStmt_Unset(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Unset_ $node)
    {
        return 'unset(' . $this->pCommaSeparated($node->vars) . ');';
    }
    protected function pStmt_InlineHTML(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\InlineHTML $node)
    {
        $newline = $node->getAttribute('hasLeadingNewline', \true) ? "\n" : '';
        return '?>' . $newline . $node->value . '<?php ';
    }
    protected function pStmt_HaltCompiler(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\HaltCompiler $node)
    {
        return '__halt_compiler();' . $node->remaining;
    }
    protected function pStmt_Nop(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Nop $node)
    {
        return '';
    }
    // Helpers
    protected function pClassCommon(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_ $node, $afterClassToken)
    {
        return $this->pAttrGroups($node->attrGroups, $node->name === null) . $this->pModifiers($node->flags) . 'class' . $afterClassToken . (null !== $node->extends ? ' extends ' . $this->p($node->extends) : '') . (!empty($node->implements) ? ' implements ' . $this->pCommaSeparated($node->implements) : '') . $this->nl . '{' . $this->pStmts($node->stmts) . $this->nl . '}';
    }
    protected function pObjectProperty($node)
    {
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr) {
            return '{' . $this->p($node) . '}';
        } else {
            return $node;
        }
    }
    protected function pEncapsList(array $encapsList, $quote)
    {
        $return = '';
        foreach ($encapsList as $element) {
            if ($element instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\EncapsedStringPart) {
                $return .= $this->escapeString($element->value, $quote);
            } else {
                $return .= '{' . $this->p($element) . '}';
            }
        }
        return $return;
    }
    protected function pSingleQuotedString(string $string)
    {
        return '\'' . \addcslashes($string, '\'\\') . '\'';
    }
    protected function escapeString($string, $quote)
    {
        if (null === $quote) {
            // For doc strings, don't escape newlines
            $escaped = \addcslashes($string, "\t\f\v\$\\");
        } else {
            $escaped = \addcslashes($string, "\n\r\t\f\v\$" . $quote . "\\");
        }
        // Escape other control characters
        return \preg_replace_callback('/([\\0-\\10\\16-\\37])(?=([0-7]?))/', function ($matches) {
            $oct = \decoct(\ord($matches[1]));
            if ($matches[2] !== '') {
                // If there is a trailing digit, use the full three character form
                return '\\' . \str_pad($oct, 3, '0', \STR_PAD_LEFT);
            }
            return '\\' . $oct;
        }, $escaped);
    }
    protected function containsEndLabel($string, $label, $atStart = \true, $atEnd = \true)
    {
        $start = $atStart ? '(?:^|[\\r\\n])' : '[\\r\\n]';
        $end = $atEnd ? '(?:$|[;\\r\\n])' : '[;\\r\\n]';
        return \false !== \strpos($string, $label) && \preg_match('/' . $start . $label . $end . '/', $string);
    }
    protected function encapsedContainsEndLabel(array $parts, $label)
    {
        foreach ($parts as $i => $part) {
            $atStart = $i === 0;
            $atEnd = $i === \count($parts) - 1;
            if ($part instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\EncapsedStringPart && $this->containsEndLabel($part->value, $label, $atStart, $atEnd)) {
                return \true;
            }
        }
        return \false;
    }
    protected function pDereferenceLhs(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node)
    {
        if (!$this->dereferenceLhsRequiresParens($node)) {
            return $this->p($node);
        } else {
            return '(' . $this->p($node) . ')';
        }
    }
    protected function pCallLhs(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node)
    {
        if (!$this->callLhsRequiresParens($node)) {
            return $this->p($node);
        } else {
            return '(' . $this->p($node) . ')';
        }
    }
    protected function pNewVariable(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node)
    {
        // TODO: This is not fully accurate.
        return $this->pDereferenceLhs($node);
    }
    /**
     * @param Node[] $nodes
     * @return bool
     */
    protected function hasNodeWithComments(array $nodes)
    {
        foreach ($nodes as $node) {
            if ($node && $node->getComments()) {
                return \true;
            }
        }
        return \false;
    }
    protected function pMaybeMultiline(array $nodes, bool $trailingComma = \false)
    {
        if (!$this->hasNodeWithComments($nodes)) {
            return $this->pCommaSeparated($nodes);
        } else {
            return $this->pCommaSeparatedMultiline($nodes, $trailingComma) . $this->nl;
        }
    }
    protected function pAttrGroups(array $nodes, bool $inline = \false) : string
    {
        $result = '';
        $sep = $inline ? ' ' : $this->nl;
        foreach ($nodes as $node) {
            $result .= $this->p($node) . $sep;
        }
        return $result;
    }
}
