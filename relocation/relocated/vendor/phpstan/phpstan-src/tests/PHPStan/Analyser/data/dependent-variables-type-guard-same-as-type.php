<?php

namespace TenantCloud\BetterReflection\Relocated\DependentVariableTypeGuardSameAsType;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty;
class Foo
{
    /**
     * @return \Generator|mixed[]|null
     */
    public function getArrayOrNull() : ?iterable
    {
        return null;
    }
    public function doFoo() : void
    {
        $associationData = $this->getArrayOrNull();
        if ($associationData === null) {
        } else {
            $itemsCounter = 0;
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('0', $itemsCounter);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Generator&iterable', $associationData);
            foreach ($associationData as $row) {
                $itemsCounter++;
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $itemsCounter);
            }
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Generator&iterable', $associationData);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $itemsCounter);
        }
    }
    public function doBar(float $f, bool $b) : void
    {
        if ($f !== 1.0) {
            $foo = 'test';
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
        if ($f !== 1.0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float', $f);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
            // could be Yes, but float type is not subtractable
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
            // could be No, but float type is not subtractable
        }
        if ($f !== 2.0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float', $f);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
        }
        if ($f !== 1.0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float', $f);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
        }
        if ($b) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
    }
}
