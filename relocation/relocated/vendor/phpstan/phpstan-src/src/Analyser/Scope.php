<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Param;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
interface Scope extends \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer
{
    public function getFile() : string;
    public function getFileDescription() : string;
    public function isDeclareStrictTypes() : bool;
    public function isInTrait() : bool;
    public function getTraitReflection() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
    /**
     * @return \PHPStan\Reflection\FunctionReflection|\PHPStan\Reflection\MethodReflection|null
     */
    public function getFunction();
    public function getFunctionName() : ?string;
    public function getNamespace() : ?string;
    public function getParentScope() : ?self;
    public function hasVariableType(string $variableName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
    public function getVariableType(string $variableName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    public function canAnyVariableExist() : bool;
    /**
     * @return array<int, string>
     */
    public function getDefinedVariables() : array;
    public function hasConstant(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $name) : bool;
    public function isInAnonymousFunction() : bool;
    public function getAnonymousFunctionReflection() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor;
    public function getAnonymousFunctionReturnType() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    public function getType(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $node) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    /**
     * Gets type of an expression with no regards to phpDocs.
     * Works for function/method parameters only.
     *
     * @internal
     * @param Expr $expr
     * @return Type
     */
    public function getNativeType(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    public function doNotTreatPhpDocTypesAsCertain() : self;
    public function resolveName(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $name) : string;
    /**
     * @param mixed $value
     */
    public function getTypeFromValue($value) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    public function isSpecified(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $node) : bool;
    public function isInClassExists(string $className) : bool;
    public function isInClosureBind() : bool;
    public function isParameterValueNullable(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Param $parameter) : bool;
    /**
     * @param \PhpParser\Node\Name|\PhpParser\Node\Identifier|\PhpParser\Node\NullableType|\PhpParser\Node\UnionType|null $type
     * @param bool $isNullable
     * @param bool $isVariadic
     * @return Type
     */
    public function getFunctionType($type, bool $isNullable, bool $isVariadic) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    public function isInExpressionAssign(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr) : bool;
    public function filterByTruthyValue(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr, bool $defaultHandleFunctions = \false) : self;
    public function filterByFalseyValue(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr, bool $defaultHandleFunctions = \false) : self;
    public function isInFirstLevelStatement() : bool;
}
