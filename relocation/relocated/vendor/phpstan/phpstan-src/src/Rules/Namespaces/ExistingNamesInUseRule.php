<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Namespaces;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Use_>
 */
class ExistingNamesInUseRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck;
    private bool $checkFunctionNameCase;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, bool $checkFunctionNameCase)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->checkFunctionNameCase = $checkFunctionNameCase;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->type === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_::TYPE_UNKNOWN) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        foreach ($node->uses as $use) {
            if ($use->type !== \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_::TYPE_UNKNOWN) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
        }
        if ($node->type === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_::TYPE_CONSTANT) {
            return $this->checkConstants($node->uses);
        }
        if ($node->type === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_::TYPE_FUNCTION) {
            return $this->checkFunctions($node->uses);
        }
        return $this->checkClasses($node->uses);
    }
    /**
     * @param \PhpParser\Node\Stmt\UseUse[] $uses
     * @return RuleError[]
     */
    private function checkConstants(array $uses) : array
    {
        $errors = [];
        foreach ($uses as $use) {
            if ($this->reflectionProvider->hasConstant($use->name, null)) {
                continue;
            }
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Used constant %s not found.', (string) $use->name))->line($use->name->getLine())->discoveringSymbolsTip()->build();
        }
        return $errors;
    }
    /**
     * @param \PhpParser\Node\Stmt\UseUse[] $uses
     * @return RuleError[]
     */
    private function checkFunctions(array $uses) : array
    {
        $errors = [];
        foreach ($uses as $use) {
            if (!$this->reflectionProvider->hasFunction($use->name, null)) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Used function %s not found.', (string) $use->name))->line($use->name->getLine())->discoveringSymbolsTip()->build();
            } elseif ($this->checkFunctionNameCase) {
                $functionReflection = $this->reflectionProvider->getFunction($use->name, null);
                $realName = $functionReflection->getName();
                $usedName = (string) $use->name;
                if (\strtolower($realName) === \strtolower($usedName) && $realName !== $usedName) {
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s used with incorrect case: %s.', $realName, $usedName))->line($use->name->getLine())->build();
                }
            }
        }
        return $errors;
    }
    /**
     * @param \PhpParser\Node\Stmt\UseUse[] $uses
     * @return RuleError[]
     */
    private function checkClasses(array $uses) : array
    {
        return $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\UseUse $use) : ClassNameNodePair {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair((string) $use->name, $use->name);
        }, $uses));
    }
}
