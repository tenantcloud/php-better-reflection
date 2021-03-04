<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Namespaces;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\GroupUse>
 */
class ExistingNamesInGroupUseRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
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
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\GroupUse::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        $errors = [];
        foreach ($node->uses as $use) {
            $error = null;
            /** @var Node\Name $name */
            $name = \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name::concat($node->prefix, $use->name, ['startLine' => $use->getLine()]);
            if ($node->type === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_::TYPE_CONSTANT || $use->type === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_::TYPE_CONSTANT) {
                $error = $this->checkConstant($name);
            } elseif ($node->type === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_::TYPE_FUNCTION || $use->type === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_::TYPE_FUNCTION) {
                $error = $this->checkFunction($name);
            } elseif ($use->type === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_::TYPE_NORMAL) {
                $error = $this->checkClass($name);
            } else {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            if ($error === null) {
                continue;
            }
            $errors[] = $error;
        }
        return $errors;
    }
    private function checkConstant(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $name) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError
    {
        if (!$this->reflectionProvider->hasConstant($name, null)) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Used constant %s not found.', (string) $name))->discoveringSymbolsTip()->line($name->getLine())->build();
        }
        return null;
    }
    private function checkFunction(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $name) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError
    {
        if (!$this->reflectionProvider->hasFunction($name, null)) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Used function %s not found.', (string) $name))->discoveringSymbolsTip()->line($name->getLine())->build();
        }
        if ($this->checkFunctionNameCase) {
            $functionReflection = $this->reflectionProvider->getFunction($name, null);
            $realName = $functionReflection->getName();
            $usedName = (string) $name;
            if (\strtolower($realName) === \strtolower($usedName) && $realName !== $usedName) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s used with incorrect case: %s.', $realName, $usedName))->line($name->getLine())->build();
            }
        }
        return null;
    }
    private function checkClass(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $name) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError
    {
        $errors = $this->classCaseSensitivityCheck->checkClassNames([new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair((string) $name, $name)]);
        if (\count($errors) === 0) {
            return null;
        } elseif (\count($errors) === 1) {
            return $errors[0];
        }
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
    }
}
