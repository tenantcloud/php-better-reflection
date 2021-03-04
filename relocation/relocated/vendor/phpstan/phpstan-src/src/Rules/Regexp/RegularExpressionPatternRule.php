<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Regexp;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
class RegularExpressionPatternRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        $patterns = $this->extractPatterns($node, $scope);
        $errors = [];
        foreach ($patterns as $pattern) {
            $errorMessage = $this->validatePattern($pattern);
            if ($errorMessage === null) {
                continue;
            }
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Regex pattern is invalid: %s', $errorMessage))->build();
        }
        return $errors;
    }
    /**
     * @param FuncCall $functionCall
     * @param Scope $scope
     * @return string[]
     */
    private function extractPatterns(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$functionCall->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            return [];
        }
        $functionName = \strtolower((string) $functionCall->name);
        if (!\TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::startsWith($functionName, 'preg_')) {
            return [];
        }
        if (!isset($functionCall->args[0])) {
            return [];
        }
        $patternNode = $functionCall->args[0]->value;
        $patternType = $scope->getType($patternNode);
        $patternStrings = [];
        foreach (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantStrings($patternType) as $constantStringType) {
            if (!\in_array($functionName, ['preg_match', 'preg_match_all', 'preg_split', 'preg_grep', 'preg_replace', 'preg_replace_callback', 'preg_filter'], \true)) {
                continue;
            }
            $patternStrings[] = $constantStringType->getValue();
        }
        foreach (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantArrays($patternType) as $constantArrayType) {
            if (\in_array($functionName, ['preg_replace', 'preg_replace_callback', 'preg_filter'], \true)) {
                foreach ($constantArrayType->getValueTypes() as $arrayKeyType) {
                    if (!$arrayKeyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
                        continue;
                    }
                    $patternStrings[] = $arrayKeyType->getValue();
                }
            }
            if ($functionName !== 'preg_replace_callback_array') {
                continue;
            }
            foreach ($constantArrayType->getKeyTypes() as $arrayKeyType) {
                if (!$arrayKeyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
                    continue;
                }
                $patternStrings[] = $arrayKeyType->getValue();
            }
        }
        return $patternStrings;
    }
    private function validatePattern(string $pattern) : ?string
    {
        try {
            \TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::match('', $pattern);
        } catch (\TenantCloud\BetterReflection\Relocated\Nette\Utils\RegexpException $e) {
            return $e->getMessage();
        }
        return null;
    }
}
