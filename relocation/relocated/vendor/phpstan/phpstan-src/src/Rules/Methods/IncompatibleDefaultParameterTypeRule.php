<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\InClassMethodNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\InClassMethodNode>
 */
class IncompatibleDefaultParameterTypeRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        $method = $scope->getFunction();
        if (!$method instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection) {
            return [];
        }
        $parameters = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants());
        $errors = [];
        foreach ($node->getOriginalNode()->getParams() as $paramI => $param) {
            if ($param->default === null) {
                continue;
            }
            if ($param->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Error || !\is_string($param->var->name)) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            $defaultValueType = $scope->getType($param->default);
            $parameterType = $parameters->getParameters()[$paramI]->getType();
            $parameterType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($parameterType);
            if ($parameterType->accepts($defaultValueType, \true)->yes()) {
                continue;
            }
            $verbosityLevel = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($parameterType, $defaultValueType);
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Default value of the parameter #%d $%s (%s) of method %s::%s() is incompatible with type %s.', $paramI + 1, $param->var->name, $defaultValueType->describe($verbosityLevel), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $parameterType->describe($verbosityLevel)))->line($param->getLine())->build();
        }
        return $errors;
    }
}
