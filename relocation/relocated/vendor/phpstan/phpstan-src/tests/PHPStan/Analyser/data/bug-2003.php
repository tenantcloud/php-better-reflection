<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Bug2003;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty;
function (array $list) : void {
    foreach ($list as $part) {
        switch (\true) {
            case isset($list['magic']):
                $key = 'to-success';
                break;
            default:
                continue 2;
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'to-success\'', $key);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $key);
        echo $key;
    }
};
