<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4346;

function () : void {
    while (\true) {
        while (\true) {
            break 2;
        }
    }
    echo 2;
};
