<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Bug4535;

function () : void {
    $Str = '"';
    while (\true) {
        switch ($Str) {
            case '"':
                break 2;
        }
    }
    echo "Unreachable?\n";
};
