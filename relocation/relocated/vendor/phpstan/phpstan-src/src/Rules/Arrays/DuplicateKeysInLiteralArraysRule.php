<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\LiteralArrayNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\LiteralArrayNode>
 */
class DuplicateKeysInLiteralArraysRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard $printer;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard $printer)
    {
        $this->printer = $printer;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Node\LiteralArrayNode::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        $values = [];
        $duplicateKeys = [];
        $printedValues = [];
        $valueLines = [];
        foreach ($node->getItemNodes() as $itemNode) {
            $item = $itemNode->getArrayItem();
            if ($item === null) {
                continue;
            }
            if ($item->key === null) {
                continue;
            }
            $key = $item->key;
            $keyType = $itemNode->getScope()->getType($key);
            if (!$keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType) {
                continue;
            }
            $printedValue = $this->printer->prettyPrintExpr($key);
            $value = $keyType->getValue();
            $printedValues[$value][] = $printedValue;
            if (!isset($valueLines[$value])) {
                $valueLines[$value] = $item->getLine();
            }
            $previousCount = \count($values);
            $values[$value] = $printedValue;
            if ($previousCount !== \count($values)) {
                continue;
            }
            $duplicateKeys[$value] = \true;
        }
        $messages = [];
        foreach (\array_keys($duplicateKeys) as $value) {
            $messages[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Array has %d %s with value %s (%s).', \count($printedValues[$value]), \count($printedValues[$value]) === 1 ? 'duplicate key' : 'duplicate keys', \var_export($value, \true), \implode(', ', $printedValues[$value])))->line($valueLines[$value])->build();
        }
        return $messages;
    }
}
