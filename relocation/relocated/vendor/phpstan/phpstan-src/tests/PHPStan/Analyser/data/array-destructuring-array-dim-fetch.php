<?php

namespace TenantCloud\BetterReflection\Relocated;

function (array $lines) {
    $barcodes = [];
    foreach ($lines as $line) {
        list($barcodes[]) = \explode(',', $line);
    }
};
function (array $lines) {
    $barcodes = [];
    foreach ($lines as $line) {
        [$barcodes[]] = \explode(',', $line);
    }
};
