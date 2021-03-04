<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierAwareExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Tests\AssertionClassMethodTypeSpecifyingExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MethodTypeSpecifyingExtension;
/**
 * @extends \PHPStan\Testing\RuleTestCase<ImpossibleCheckTypeMethodCallRule>
 */
class ImpossibleCheckTypeMethodCallRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    public function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison\ImpossibleCheckTypeMethodCallRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper($this->createReflectionProvider(), $this->getTypeSpecifier(), [], $this->treatPhpDocTypesAsCertain), \true, $this->treatPhpDocTypesAsCertain);
    }
    protected function shouldTreatPhpDocTypesAsCertain() : bool
    {
        return $this->treatPhpDocTypesAsCertain;
    }
    /**
     * @return MethodTypeSpecifyingExtension[]
     */
    protected function getMethodTypeSpecifyingExtensions() : array
    {
        return [new \TenantCloud\BetterReflection\Relocated\PHPStan\Tests\AssertionClassMethodTypeSpecifyingExtension(null), new class implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MethodTypeSpecifyingExtension, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierAwareExtension
        {
            /** @var TypeSpecifier */
            private $typeSpecifier;
            public function setTypeSpecifier(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
            {
                $this->typeSpecifier = $typeSpecifier;
            }
            public function getClass() : string
            {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Tests\AssertionClass::class;
            }
            public function isMethodSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : bool
            {
                return $methodReflection->getName() === 'assertNotInt' && \count($node->args) > 0;
            }
            public function specifyTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes
            {
                return $this->typeSpecifier->specifyTypesInCondition($scope, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BooleanNot(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name('is_int'), [$node->args[0]])), \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTruthy());
            }
        }, new class implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MethodTypeSpecifyingExtension, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierAwareExtension
        {
            /** @var TypeSpecifier */
            private $typeSpecifier;
            public function setTypeSpecifier(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
            {
                $this->typeSpecifier = $typeSpecifier;
            }
            public function getClass() : string
            {
                return \TenantCloud\BetterReflection\Relocated\ImpossibleMethodCall\Foo::class;
            }
            public function isMethodSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : bool
            {
                return $methodReflection->getName() === 'isSame' && \count($node->args) >= 2;
            }
            public function specifyTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes
            {
                return $this->typeSpecifier->specifyTypesInCondition($scope, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Identical($node->args[0]->value, $node->args[1]->value), \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTruthy());
            }
        }, new class implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MethodTypeSpecifyingExtension, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierAwareExtension
        {
            /** @var TypeSpecifier */
            private $typeSpecifier;
            public function setTypeSpecifier(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
            {
                $this->typeSpecifier = $typeSpecifier;
            }
            public function getClass() : string
            {
                return \TenantCloud\BetterReflection\Relocated\ImpossibleMethodCall\Foo::class;
            }
            public function isMethodSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : bool
            {
                return $methodReflection->getName() === 'isNotSame' && \count($node->args) >= 2;
            }
            public function specifyTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes
            {
                return $this->typeSpecifier->specifyTypesInCondition($scope, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\NotIdentical($node->args[0]->value, $node->args[1]->value), \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTruthy());
            }
        }];
    }
    public function testRule() : void
    {
        $this->treatPhpDocTypesAsCertain = \true;
        $this->analyse([__DIR__ . '/data/impossible-method-call.php'], [['Call to method PHPStan\\Tests\\AssertionClass::assertString() with string will always evaluate to true.', 14], ['Call to method PHPStan\\Tests\\AssertionClass::assertString() with int will always evaluate to false.', 15], ['Call to method PHPStan\\Tests\\AssertionClass::assertNotInt() with int will always evaluate to false.', 30], ['Call to method PHPStan\\Tests\\AssertionClass::assertNotInt() with string will always evaluate to true.', 36], ['Call to method ImpossibleMethodCall\\Foo::isSame() with 1 and 1 will always evaluate to true.', 60], ['Call to method ImpossibleMethodCall\\Foo::isSame() with 1 and 2 will always evaluate to false.', 63], ['Call to method ImpossibleMethodCall\\Foo::isNotSame() with 1 and 1 will always evaluate to false.', 66], ['Call to method ImpossibleMethodCall\\Foo::isNotSame() with 1 and 2 will always evaluate to true.', 69], ['Call to method ImpossibleMethodCall\\Foo::isSame() with stdClass and stdClass will always evaluate to true.', 78]]);
    }
    public function testDoNotReportPhpDoc() : void
    {
        $this->treatPhpDocTypesAsCertain = \false;
        $this->analyse([__DIR__ . '/data/impossible-method-call-not-phpdoc.php'], [['Call to method PHPStan\\Tests\\AssertionClass::assertString() with string will always evaluate to true.', 17], ['Call to method PHPStan\\Tests\\AssertionClass::assertString() with string will always evaluate to true.', 19]]);
    }
    public function testReportPhpDoc() : void
    {
        $this->treatPhpDocTypesAsCertain = \true;
        $this->analyse([__DIR__ . '/data/impossible-method-call-not-phpdoc.php'], [['Call to method PHPStan\\Tests\\AssertionClass::assertString() with string will always evaluate to true.', 17], ['Call to method PHPStan\\Tests\\AssertionClass::assertString() with string will always evaluate to true.', 18, 'Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.'], ['Call to method PHPStan\\Tests\\AssertionClass::assertString() with string will always evaluate to true.', 19]]);
    }
}
