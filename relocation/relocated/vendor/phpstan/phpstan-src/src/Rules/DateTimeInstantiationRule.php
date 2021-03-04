<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

use DateTime;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\New_;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\New_>
 */
class DateTimeInstantiationRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\New_::class;
    }
    /**
     * @param New_ $node
     */
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name || \count($node->args) === 0 || !\in_array(\strtolower((string) $node->class), ['datetime', 'datetimeimmutable'], \true)) {
            return [];
        }
        $arg = $scope->getType($node->args[0]->value);
        if (!$arg instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
            return [];
        }
        $errors = [];
        $dateString = $arg->getValue();
        try {
            new \DateTime($dateString);
        } catch (\Throwable $e) {
            // an exception is thrown for errors only but we want to catch warnings too
        }
        $lastErrors = \DateTime::getLastErrors();
        if ($lastErrors !== \false) {
            foreach ($lastErrors['errors'] as $error) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instantiating %s with %s produces an error: %s', (string) $node->class, $dateString, $error))->build();
            }
        }
        return $errors;
    }
}
