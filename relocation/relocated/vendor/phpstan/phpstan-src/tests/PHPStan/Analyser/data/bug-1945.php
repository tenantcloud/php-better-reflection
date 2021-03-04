<?php

namespace TenantCloud\BetterReflection\Relocated\Bug1945;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty;
function () : void {
    foreach (["a", "b", "c"] as $letter) {
        switch ($letter) {
            case "b":
                $foo = 1;
                break;
            case "c":
                $foo = 2;
                break;
            default:
                continue 2;
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2', $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $foo);
    }
};
function () : void {
    foreach (["a", "b", "c"] as $letter) {
        switch ($letter) {
            case "a":
                if (\rand(0, 10) === 1) {
                    continue 2;
                }
                $foo = 1;
                break;
            case "b":
                if (\rand(0, 10) === 1) {
                    continue 2;
                }
                $foo = 2;
                break;
            default:
                continue 2;
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1|2', $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $foo);
    }
};
function (array $docs) : void {
    foreach ($docs as $doc) {
        switch (\true) {
            case 'bar':
                continue 2;
                break;
            default:
                $foo = $doc;
                break;
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $foo);
        if (!$foo) {
            return;
        }
    }
};
function (array $docs) : void {
    foreach ($docs as $doc) {
        switch (\true) {
            case 'bar':
                continue 2;
            default:
                $foo = $doc;
                break;
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $foo);
        if (!$foo) {
            return;
        }
    }
};
function (array $items) : string {
    foreach ($items as $item) {
        switch ($item) {
            case 1:
                $string = 'a';
                break;
            case 2:
                $string = 'b';
                break;
            default:
                continue 2;
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'a\'|\'b\'', $string);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $string);
        return 'result: ' . $string;
    }
    return 'ok';
};
