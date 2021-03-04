<?php

namespace TenantCloud\BetterReflection\Relocated;

// Don't redefine the functions if included multiple times.
if (!\function_exists('TenantCloud\\BetterReflection\\Relocated\\RingCentral\\Psr7\\str')) {
    require __DIR__ . '/functions.php';
}
