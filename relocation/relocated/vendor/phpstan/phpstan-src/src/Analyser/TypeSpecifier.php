<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\LogicalOr;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ConstFetch;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Instanceof_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\New_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasOffsetType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NonexistentParentClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticTypeFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
use function array_reverse;
class TypeSpecifier
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard $printer;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    /** @var \PHPStan\Type\FunctionTypeSpecifyingExtension[] */
    private array $functionTypeSpecifyingExtensions;
    /** @var \PHPStan\Type\MethodTypeSpecifyingExtension[] */
    private array $methodTypeSpecifyingExtensions;
    /** @var \PHPStan\Type\StaticMethodTypeSpecifyingExtension[] */
    private array $staticMethodTypeSpecifyingExtensions;
    /** @var \PHPStan\Type\MethodTypeSpecifyingExtension[][]|null */
    private ?array $methodTypeSpecifyingExtensionsByClass = null;
    /** @var \PHPStan\Type\StaticMethodTypeSpecifyingExtension[][]|null */
    private ?array $staticMethodTypeSpecifyingExtensionsByClass = null;
    /**
     * @param \PhpParser\PrettyPrinter\Standard $printer
     * @param ReflectionProvider $reflectionProvider
     * @param \PHPStan\Type\FunctionTypeSpecifyingExtension[] $functionTypeSpecifyingExtensions
     * @param \PHPStan\Type\MethodTypeSpecifyingExtension[] $methodTypeSpecifyingExtensions
     * @param \PHPStan\Type\StaticMethodTypeSpecifyingExtension[] $staticMethodTypeSpecifyingExtensions
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard $printer, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $functionTypeSpecifyingExtensions, array $methodTypeSpecifyingExtensions, array $staticMethodTypeSpecifyingExtensions)
    {
        $this->printer = $printer;
        $this->reflectionProvider = $reflectionProvider;
        foreach (\array_merge($functionTypeSpecifyingExtensions, $methodTypeSpecifyingExtensions, $staticMethodTypeSpecifyingExtensions) as $extension) {
            if (!$extension instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierAwareExtension) {
                continue;
            }
            $extension->setTypeSpecifier($this);
        }
        $this->functionTypeSpecifyingExtensions = $functionTypeSpecifyingExtensions;
        $this->methodTypeSpecifyingExtensions = $methodTypeSpecifyingExtensions;
        $this->staticMethodTypeSpecifyingExtensions = $staticMethodTypeSpecifyingExtensions;
    }
    public function specifyTypesInCondition(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context, bool $defaultHandleFunctions = \false) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes
    {
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Instanceof_) {
            $exprNode = $expr->expr;
            if ($exprNode instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Assign) {
                $exprNode = $exprNode->var;
            }
            if ($expr->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
                $className = (string) $expr->class;
                $lowercasedClassName = \strtolower($className);
                if ($lowercasedClassName === 'self' && $scope->isInClass()) {
                    $type = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($scope->getClassReflection()->getName());
                } elseif ($lowercasedClassName === 'static' && $scope->isInClass()) {
                    $type = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType($scope->getClassReflection()->getName());
                } elseif ($lowercasedClassName === 'parent') {
                    if ($scope->isInClass() && $scope->getClassReflection()->getParentClass() !== \false) {
                        $type = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($scope->getClassReflection()->getParentClass()->getName());
                    } else {
                        $type = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NonexistentParentClassType();
                    }
                } else {
                    $type = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($className);
                }
                return $this->create($exprNode, $type, $context);
            }
            $classType = $scope->getType($expr->class);
            $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($classType, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) : Type {
                if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType || $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
                    return $traverse($type);
                }
                if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName) {
                    return $type;
                }
                if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType) {
                    return $type->getGenericType();
                }
                if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($type->getValue());
                }
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
            });
            if (!$type->isSuperTypeOf(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType())->yes()) {
                if ($context->true()) {
                    $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect($type, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType());
                    return $this->create($exprNode, $type, $context);
                } elseif ($context->false()) {
                    $exprType = $scope->getType($expr->expr);
                    if (!$type->isSuperTypeOf($exprType)->yes()) {
                        return $this->create($exprNode, $type, $context);
                    }
                }
            }
            if ($context->true()) {
                return $this->create($exprNode, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), $context);
            }
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Identical) {
            $expressions = $this->findTypeExpressionsFromBinaryOperation($scope, $expr);
            if ($expressions !== null) {
                /** @var Expr $exprNode */
                $exprNode = $expressions[0];
                if ($exprNode instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Assign) {
                    $exprNode = $exprNode->var;
                }
                /** @var \PHPStan\Type\ConstantScalarType $constantType */
                $constantType = $expressions[1];
                if ($constantType->getValue() === \false) {
                    $types = $this->create($exprNode, $constantType, $context);
                    return $types->unionWith($this->specifyTypesInCondition($scope, $exprNode, $context->true() ? \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createFalse() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createFalse()->negate()));
                }
                if ($constantType->getValue() === \true) {
                    $types = $this->create($exprNode, $constantType, $context);
                    return $types->unionWith($this->specifyTypesInCondition($scope, $exprNode, $context->true() ? \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTrue() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTrue()->negate()));
                }
                if ($constantType->getValue() === null) {
                    return $this->create($exprNode, $constantType, $context);
                }
                if (!$context->null() && $exprNode instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall && \count($exprNode->args) === 1 && $exprNode->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name && \strtolower((string) $exprNode->name) === 'count' && $constantType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
                    if ($context->truthy() || $constantType->getValue() === 0) {
                        $newContext = $context;
                        if ($constantType->getValue() === 0) {
                            $newContext = $newContext->negate();
                        }
                        $argType = $scope->getType($exprNode->args[0]->value);
                        if ((new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()))->isSuperTypeOf($argType)->yes()) {
                            return $this->create($exprNode->args[0]->value, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType(), $newContext);
                        }
                    }
                }
            }
            if ($context->true()) {
                $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect($scope->getType($expr->right), $scope->getType($expr->left));
                $leftTypes = $this->create($expr->left, $type, $context);
                $rightTypes = $this->create($expr->right, $type, $context);
                return $leftTypes->unionWith($rightTypes);
            } elseif ($context->false()) {
                $identicalType = $scope->getType($expr);
                if ($identicalType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType) {
                    $never = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType();
                    $contextForTypes = $identicalType->getValue() ? $context->negate() : $context;
                    $leftTypes = $this->create($expr->left, $never, $contextForTypes);
                    $rightTypes = $this->create($expr->right, $never, $contextForTypes);
                    return $leftTypes->unionWith($rightTypes);
                }
                $exprLeftType = $scope->getType($expr->left);
                $exprRightType = $scope->getType($expr->right);
                $types = null;
                if ($exprLeftType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantType && !$expr->right instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar) {
                    $types = $this->create($expr->right, $exprLeftType, $context);
                }
                if ($exprRightType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantType && !$expr->left instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar) {
                    $leftType = $this->create($expr->left, $exprRightType, $context);
                    if ($types !== null) {
                        $types = $types->unionWith($leftType);
                    } else {
                        $types = $leftType;
                    }
                }
                if ($types !== null) {
                    return $types;
                }
            }
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return $this->specifyTypesInCondition($scope, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BooleanNot(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Identical($expr->left, $expr->right)), $context);
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Equal) {
            $expressions = $this->findTypeExpressionsFromBinaryOperation($scope, $expr);
            if ($expressions !== null) {
                /** @var Expr $exprNode */
                $exprNode = $expressions[0];
                /** @var \PHPStan\Type\ConstantScalarType $constantType */
                $constantType = $expressions[1];
                if ($constantType->getValue() === \false || $constantType->getValue() === null) {
                    return $this->specifyTypesInCondition($scope, $exprNode, $context->true() ? \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createFalsey() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createFalsey()->negate());
                }
                if ($constantType->getValue() === \true) {
                    return $this->specifyTypesInCondition($scope, $exprNode, $context->true() ? \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTruthy() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTruthy()->negate());
                }
            }
            $leftType = $scope->getType($expr->left);
            $leftBooleanType = $leftType->toBoolean();
            $rightType = $scope->getType($expr->right);
            if ($leftBooleanType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType && $rightType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType) {
                return $this->specifyTypesInCondition($scope, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Identical(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ConstFetch(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name($leftBooleanType->getValue() ? 'true' : 'false')), $expr->right), $context);
            }
            $rightBooleanType = $rightType->toBoolean();
            if ($rightBooleanType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType && $leftType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType) {
                return $this->specifyTypesInCondition($scope, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Identical($expr->left, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ConstFetch(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name($rightBooleanType->getValue() ? 'true' : 'false'))), $context);
            }
            if ($expr->left instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall && $expr->left->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name && \strtolower($expr->left->name->toString()) === 'get_class' && isset($expr->left->args[0]) && $rightType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
                return $this->specifyTypesInCondition($scope, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Instanceof_($expr->left->args[0]->value, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name($rightType->getValue())), $context);
            }
            if ($expr->right instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall && $expr->right->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name && \strtolower($expr->right->name->toString()) === 'get_class' && isset($expr->right->args[0]) && $leftType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
                return $this->specifyTypesInCondition($scope, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Instanceof_($expr->right->args[0]->value, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name($leftType->getValue())), $context);
            }
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\NotEqual) {
            return $this->specifyTypesInCondition($scope, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BooleanNot(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Equal($expr->left, $expr->right)), $context);
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Smaller || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual) {
            $orEqual = $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual;
            $offset = $orEqual ? 0 : 1;
            $leftType = $scope->getType($expr->left);
            $rightType = $scope->getType($expr->right);
            if ($expr->left instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall && \count($expr->left->args) === 1 && $expr->left->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name && \strtolower((string) $expr->left->name) === 'count' && $rightType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType && (!$expr->right instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall || !$expr->right->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name || \strtolower((string) $expr->right->name) !== 'count')) {
                $inverseOperator = $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Smaller ? new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual($expr->right, $expr->left) : new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Smaller($expr->right, $expr->left);
                return $this->specifyTypesInCondition($scope, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BooleanNot($inverseOperator), $context);
            }
            $result = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes();
            if (!$context->null() && $expr->right instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall && \count($expr->right->args) === 1 && $expr->right->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name && \strtolower((string) $expr->right->name) === 'count' && $leftType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
                if ($context->truthy() || $leftType->getValue() + $offset === 1) {
                    $argType = $scope->getType($expr->right->args[0]->value);
                    if ((new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()))->isSuperTypeOf($argType)->yes()) {
                        $result = $result->unionWith($this->create($expr->right->args[0]->value, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType(), $context));
                    }
                }
            }
            if ($leftType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
                if ($expr->right instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PostInc) {
                    $result = $result->unionWith($this->createRangeTypes($expr->right->var, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::fromInterval($leftType->getValue(), null, $offset + 1), $context));
                } elseif ($expr->right instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PostDec) {
                    $result = $result->unionWith($this->createRangeTypes($expr->right->var, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::fromInterval($leftType->getValue(), null, $offset - 1), $context));
                } elseif ($expr->right instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PreInc || $expr->right instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PreDec) {
                    $result = $result->unionWith($this->createRangeTypes($expr->right->var, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::fromInterval($leftType->getValue(), null, $offset), $context));
                }
            }
            if ($rightType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
                if ($expr->left instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PostInc) {
                    $result = $result->unionWith($this->createRangeTypes($expr->left->var, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::fromInterval(null, $rightType->getValue(), -$offset + 1), $context));
                } elseif ($expr->left instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PostDec) {
                    $result = $result->unionWith($this->createRangeTypes($expr->left->var, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::fromInterval(null, $rightType->getValue(), -$offset - 1), $context));
                } elseif ($expr->left instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PreInc || $expr->left instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PreDec) {
                    $result = $result->unionWith($this->createRangeTypes($expr->left->var, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::fromInterval(null, $rightType->getValue(), -$offset), $context));
                }
            }
            if ($context->truthy()) {
                if (!$expr->left instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar) {
                    $result = $result->unionWith($this->create($expr->left, $orEqual ? $rightType->getSmallerOrEqualType() : $rightType->getSmallerType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTruthy()));
                }
                if (!$expr->right instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar) {
                    $result = $result->unionWith($this->create($expr->right, $orEqual ? $leftType->getGreaterOrEqualType() : $leftType->getGreaterType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTruthy()));
                }
            } elseif ($context->falsey()) {
                if (!$expr->left instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar) {
                    $result = $result->unionWith($this->create($expr->left, $orEqual ? $rightType->getGreaterType() : $rightType->getGreaterOrEqualType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTruthy()));
                }
                if (!$expr->right instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar) {
                    $result = $result->unionWith($this->create($expr->right, $orEqual ? $leftType->getSmallerType() : $leftType->getSmallerOrEqualType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTruthy()));
                }
            }
            return $result;
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Greater) {
            return $this->specifyTypesInCondition($scope, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Smaller($expr->right, $expr->left), $context, $defaultHandleFunctions);
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual) {
            return $this->specifyTypesInCondition($scope, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual($expr->right, $expr->left), $context, $defaultHandleFunctions);
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall && $expr->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            if ($this->reflectionProvider->hasFunction($expr->name, $scope)) {
                $functionReflection = $this->reflectionProvider->getFunction($expr->name, $scope);
                foreach ($this->getFunctionTypeSpecifyingExtensions() as $extension) {
                    if (!$extension->isFunctionSupported($functionReflection, $expr, $context)) {
                        continue;
                    }
                    return $extension->specifyTypes($functionReflection, $expr, $scope, $context);
                }
            }
            if ($defaultHandleFunctions) {
                return $this->handleDefaultTruthyOrFalseyContext($context, $expr);
            }
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall && $expr->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
            $methodCalledOnType = $scope->getType($expr->var);
            $referencedClasses = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getDirectClassNames($methodCalledOnType);
            if (\count($referencedClasses) === 1 && $this->reflectionProvider->hasClass($referencedClasses[0])) {
                $methodClassReflection = $this->reflectionProvider->getClass($referencedClasses[0]);
                if ($methodClassReflection->hasMethod($expr->name->name)) {
                    $methodReflection = $methodClassReflection->getMethod($expr->name->name, $scope);
                    foreach ($this->getMethodTypeSpecifyingExtensionsForClass($methodClassReflection->getName()) as $extension) {
                        if (!$extension->isMethodSupported($methodReflection, $expr, $context)) {
                            continue;
                        }
                        return $extension->specifyTypes($methodReflection, $expr, $scope, $context);
                    }
                }
            }
            if ($defaultHandleFunctions) {
                return $this->handleDefaultTruthyOrFalseyContext($context, $expr);
            }
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall && $expr->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
            if ($expr->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
                $calleeType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($scope->resolveName($expr->class));
            } else {
                $calleeType = $scope->getType($expr->class);
            }
            if ($calleeType->hasMethod($expr->name->name)->yes()) {
                $staticMethodReflection = $calleeType->getMethod($expr->name->name, $scope);
                $referencedClasses = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getDirectClassNames($calleeType);
                if (\count($referencedClasses) === 1 && $this->reflectionProvider->hasClass($referencedClasses[0])) {
                    $staticMethodClassReflection = $this->reflectionProvider->getClass($referencedClasses[0]);
                    foreach ($this->getStaticMethodTypeSpecifyingExtensionsForClass($staticMethodClassReflection->getName()) as $extension) {
                        if (!$extension->isStaticMethodSupported($staticMethodReflection, $expr, $context)) {
                            continue;
                        }
                        return $extension->specifyTypes($staticMethodReflection, $expr, $scope, $context);
                    }
                }
            }
            if ($defaultHandleFunctions) {
                return $this->handleDefaultTruthyOrFalseyContext($context, $expr);
            }
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BooleanAnd || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\LogicalAnd) {
            $leftTypes = $this->specifyTypesInCondition($scope, $expr->left, $context);
            $rightTypes = $this->specifyTypesInCondition($scope, $expr->right, $context);
            return $context->true() ? $leftTypes->unionWith($rightTypes) : $leftTypes->intersectWith($rightTypes);
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BooleanOr || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\LogicalOr) {
            $leftTypes = $this->specifyTypesInCondition($scope, $expr->left, $context);
            $rightTypes = $this->specifyTypesInCondition($scope, $expr->right, $context);
            return $context->true() ? $leftTypes->intersectWith($rightTypes) : $leftTypes->unionWith($rightTypes);
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BooleanNot && !$context->null()) {
            return $this->specifyTypesInCondition($scope, $expr->expr, $context->negate());
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Assign) {
            if (!$scope instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            if ($context->null()) {
                return $this->specifyTypesInCondition($scope->exitFirstLevelStatements(), $expr->expr, $context);
            }
            return $this->specifyTypesInCondition($scope->exitFirstLevelStatements(), $expr->var, $context);
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Isset_ && \count($expr->vars) > 0 && $context->true() || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Empty_ && $context->false()) {
            $vars = [];
            if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Isset_) {
                $varsToIterate = $expr->vars;
            } else {
                $varsToIterate = [$expr->expr];
            }
            foreach ($varsToIterate as $var) {
                $tmpVars = [$var];
                while ($var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch || $var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch || $var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch && $var->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr) {
                    if ($var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch) {
                        /** @var Expr $var */
                        $var = $var->class;
                    } else {
                        $var = $var->var;
                    }
                    $tmpVars[] = $var;
                }
                $vars = \array_merge($vars, \array_reverse($tmpVars));
            }
            if (\count($vars) === 0) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            $types = null;
            foreach ($vars as $var) {
                if ($var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable && \is_string($var->name)) {
                    if ($scope->hasVariableType($var->name)->no()) {
                        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes([], []);
                    }
                }
                if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Isset_) {
                    if ($var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch && $var->dim !== null && !$scope->getType($var->var) instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType) {
                        $type = $this->create($var->var, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasOffsetType($scope->getType($var->dim)), $context)->unionWith($this->create($var, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createFalse()));
                    } else {
                        $type = $this->create($var, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createFalse());
                    }
                } else {
                    $type = $this->create($var, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false)]), \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createFalse());
                }
                if ($var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch && $var->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
                    $type = $type->unionWith($this->create($var->var, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType($var->name->toString())]), \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTruthy()));
                } elseif ($var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch && $var->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr && $var->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\VarLikeIdentifier) {
                    $type = $type->unionWith($this->create($var->class, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType($var->name->toString())]), \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTruthy()));
                }
                if ($types === null) {
                    $types = $type;
                } else {
                    $types = $types->unionWith($type);
                }
            }
            if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Empty_ && (new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()))->isSuperTypeOf($scope->getType($expr->expr))->yes()) {
                $types = $types->unionWith($this->create($expr->expr, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType(), $context->negate()));
            }
            return $types;
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Empty_ && $context->truthy() && (new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()))->isSuperTypeOf($scope->getType($expr->expr))->yes()) {
            return $this->create($expr->expr, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType(), $context->negate());
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ErrorSuppress) {
            return $this->specifyTypesInCondition($scope, $expr->expr, $context, $defaultHandleFunctions);
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\NullsafePropertyFetch && !$context->null()) {
            $types = $this->specifyTypesInCondition($scope, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BooleanAnd(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\NotIdentical($expr->var, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ConstFetch(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name('null'))), new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch($expr->var, $expr->name)), $context, $defaultHandleFunctions);
            $nullSafeTypes = $this->handleDefaultTruthyOrFalseyContext($context, $expr);
            return $context->true() ? $types->unionWith($nullSafeTypes) : $types->intersectWith($nullSafeTypes);
        } elseif (!$context->null()) {
            return $this->handleDefaultTruthyOrFalseyContext($context, $expr);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes();
    }
    private function handleDefaultTruthyOrFalseyContext(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes
    {
        if (!$context->truthy()) {
            $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticTypeFactory::truthy();
            return $this->create($expr, $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createFalse());
        } elseif (!$context->falsey()) {
            $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticTypeFactory::falsey();
            return $this->create($expr, $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createFalse());
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes();
    }
    /**
     * @param \PHPStan\Analyser\Scope $scope
     * @param \PhpParser\Node\Expr\BinaryOp $binaryOperation
     * @return (Expr|\PHPStan\Type\ConstantScalarType)[]|null
     */
    private function findTypeExpressionsFromBinaryOperation(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp $binaryOperation) : ?array
    {
        $leftType = $scope->getType($binaryOperation->left);
        $rightType = $scope->getType($binaryOperation->right);
        if ($leftType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType && !$binaryOperation->right instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ConstFetch && !$binaryOperation->right instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ClassConstFetch) {
            return [$binaryOperation->right, $leftType];
        } elseif ($rightType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType && !$binaryOperation->left instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ConstFetch && !$binaryOperation->left instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ClassConstFetch) {
            return [$binaryOperation->left, $rightType];
        }
        return null;
    }
    public function create(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context, bool $overwrite = \false) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes
    {
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\New_ || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Instanceof_) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes();
        }
        $sureTypes = [];
        $sureNotTypes = [];
        $exprString = $this->printer->prettyPrintExpr($expr);
        if ($context->false()) {
            $sureNotTypes[$exprString] = [$expr, $type];
        } elseif ($context->true()) {
            $sureTypes[$exprString] = [$expr, $type];
        }
        $types = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes($sureTypes, $sureNotTypes, $overwrite);
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\NullsafePropertyFetch && !$context->null()) {
            $propertyFetchTypes = $this->create(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch($expr->var, $expr->name), $type, $context);
            if ($context->true() && !\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::containsNull($type)) {
                $propertyFetchTypes = $propertyFetchTypes->unionWith($this->create($expr->var, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createFalse()));
            } elseif ($context->false() && \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::containsNull($type)) {
                $propertyFetchTypes = $propertyFetchTypes->unionWith($this->create($expr->var, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createFalse()));
            }
            return $types->unionWith($propertyFetchTypes);
        }
        return $types;
    }
    private function createRangeTypes(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes
    {
        $sureNotTypes = [];
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType || $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
            $exprString = $this->printer->prettyPrintExpr($expr);
            if ($context->false()) {
                $sureNotTypes[$exprString] = [$expr, $type];
            } elseif ($context->true()) {
                $inverted = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), $type);
                $sureNotTypes[$exprString] = [$expr, $inverted];
            }
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes([], $sureNotTypes);
    }
    /**
     * @return \PHPStan\Type\FunctionTypeSpecifyingExtension[]
     */
    private function getFunctionTypeSpecifyingExtensions() : array
    {
        return $this->functionTypeSpecifyingExtensions;
    }
    /**
     * @param string $className
     * @return \PHPStan\Type\MethodTypeSpecifyingExtension[]
     */
    private function getMethodTypeSpecifyingExtensionsForClass(string $className) : array
    {
        if ($this->methodTypeSpecifyingExtensionsByClass === null) {
            $byClass = [];
            foreach ($this->methodTypeSpecifyingExtensions as $extension) {
                $byClass[$extension->getClass()][] = $extension;
            }
            $this->methodTypeSpecifyingExtensionsByClass = $byClass;
        }
        return $this->getTypeSpecifyingExtensionsForType($this->methodTypeSpecifyingExtensionsByClass, $className);
    }
    /**
     * @param string $className
     * @return \PHPStan\Type\StaticMethodTypeSpecifyingExtension[]
     */
    private function getStaticMethodTypeSpecifyingExtensionsForClass(string $className) : array
    {
        if ($this->staticMethodTypeSpecifyingExtensionsByClass === null) {
            $byClass = [];
            foreach ($this->staticMethodTypeSpecifyingExtensions as $extension) {
                $byClass[$extension->getClass()][] = $extension;
            }
            $this->staticMethodTypeSpecifyingExtensionsByClass = $byClass;
        }
        return $this->getTypeSpecifyingExtensionsForType($this->staticMethodTypeSpecifyingExtensionsByClass, $className);
    }
    /**
     * @param \PHPStan\Type\MethodTypeSpecifyingExtension[][]|\PHPStan\Type\StaticMethodTypeSpecifyingExtension[][] $extensions
     * @param string $className
     * @return mixed[]
     */
    private function getTypeSpecifyingExtensionsForType(array $extensions, string $className) : array
    {
        $extensionsForClass = [[]];
        $class = $this->reflectionProvider->getClass($className);
        foreach (\array_merge([$className], $class->getParentClassesNames(), $class->getNativeReflection()->getInterfaceNames()) as $extensionClassName) {
            if (!isset($extensions[$extensionClassName])) {
                continue;
            }
            $extensionsForClass[] = $extensions[$extensionClassName];
        }
        return \array_merge(...$extensionsForClass);
    }
}
