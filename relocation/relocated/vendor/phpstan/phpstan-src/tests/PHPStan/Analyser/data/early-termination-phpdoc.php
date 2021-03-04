<?php

namespace TenantCloud\BetterReflection\Relocated\EarlyTermination;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty;
function () : void {
    if (\rand(0, 1)) {
        \TenantCloud\BetterReflection\Relocated\EarlyTermination\Foo::doBarPhpDoc();
    } else {
        $a = 1;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $a);
};
function () : void {
    if (\rand(0, 1)) {
        (new \TenantCloud\BetterReflection\Relocated\EarlyTermination\Foo())->doFooPhpDoc();
    } else {
        $a = 1;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $a);
};
function () : void {
    if (\rand(0, 1)) {
        bazPhpDoc();
    } else {
        $a = 1;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $a);
};
function () : void {
    if (\rand(0, 1)) {
        bazPhpDoc2();
    } else {
        $a = 1;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $a);
};
