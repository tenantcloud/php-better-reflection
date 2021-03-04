<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
/**
 * @extends \PHPStan\Testing\RuleTestCase<IfConstantConditionRule>
 */
class IfConstantConditionRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison\IfConstantConditionRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison\ConstantConditionRuleHelper(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper($this->createReflectionProvider(), $this->getTypeSpecifier(), [], $this->treatPhpDocTypesAsCertain), $this->treatPhpDocTypesAsCertain), $this->treatPhpDocTypesAsCertain);
    }
    protected function shouldTreatPhpDocTypesAsCertain() : bool
    {
        return $this->treatPhpDocTypesAsCertain;
    }
    /**
     * @return DynamicFunctionReturnTypeExtension[]
     */
    public function getDynamicFunctionReturnTypeExtensions() : array
    {
        return [new class implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
        {
            public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
            {
                return $functionReflection->getName() === 'always_true';
            }
            public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
            {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true);
            }
        }];
    }
    public function testRule() : void
    {
        $this->treatPhpDocTypesAsCertain = \true;
        require_once __DIR__ . '/data/function-definition.php';
        $this->analyse([__DIR__ . '/data/if-condition.php'], [['If condition is always true.', 40], ['If condition is always false.', 45], ['If condition is always true.', 96], ['If condition is always true.', 110], ['If condition is always true.', 113], ['If condition is always true.', 127], ['If condition is always true.', 287], ['If condition is always false.', 291]]);
    }
    public function testDoNotReportPhpDoc() : void
    {
        $this->treatPhpDocTypesAsCertain = \false;
        $this->analyse([__DIR__ . '/data/if-condition-not-phpdoc.php'], [['If condition is always true.', 16]]);
    }
    public function testReportPhpDoc() : void
    {
        $this->treatPhpDocTypesAsCertain = \true;
        $this->analyse([__DIR__ . '/data/if-condition-not-phpdoc.php'], [['If condition is always true.', 16], ['If condition is always true.', 20, 'Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.']]);
    }
    public function testBug4043() : void
    {
        $this->treatPhpDocTypesAsCertain = \true;
        $this->analyse([__DIR__ . '/data/bug-4043.php'], [['If condition is always false.', 43], ['If condition is always true.', 50]]);
    }
}
