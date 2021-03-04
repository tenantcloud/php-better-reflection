<?php

namespace TenantCloud\BetterReflection\Relocated\Analyser\Bug2750;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function (array $input) {
    \assert(\count($input) > 0);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', \count($input));
    \array_shift($input);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', \count($input));
    \assert(\count($input) > 0);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', \count($input));
    \array_pop($input);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', \count($input));
    \assert(\count($input) > 0);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', \count($input));
    \array_unshift($input, 'test');
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', \count($input));
    \assert(\count($input) > 0);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', \count($input));
    \array_push($input, 'nope');
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', \count($input));
};
