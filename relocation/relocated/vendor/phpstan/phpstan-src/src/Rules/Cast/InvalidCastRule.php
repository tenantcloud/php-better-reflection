<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Cast;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Cast>
 */
class InvalidCastRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        $castTypeCallback = static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($node) : ?Type {
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Int_) {
                return $type->toInteger();
            } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Bool_) {
                return $type->toBoolean();
            } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\Double) {
                return $type->toFloat();
            } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast\String_) {
                return $type->toString();
            }
            return null;
        };
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->expr, '', static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($castTypeCallback) : bool {
            $castType = $castTypeCallback($type);
            if ($castType === null) {
                return \true;
            }
            return !$castType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
        });
        $type = $typeResult->getType();
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
            return [];
        }
        $castType = $castTypeCallback($type);
        if ($castType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
            $classReflection = $this->reflectionProvider->getClass(\get_class($node));
            $shortName = $classReflection->getNativeReflection()->getShortName();
            $shortName = \strtolower($shortName);
            if ($shortName === 'double') {
                $shortName = 'float';
            } else {
                $shortName = \substr($shortName, 0, -1);
            }
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot cast %s to %s.', $scope->getType($node->expr)->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()), $shortName))->line($node->getLine())->build()];
        }
        return [];
    }
}
