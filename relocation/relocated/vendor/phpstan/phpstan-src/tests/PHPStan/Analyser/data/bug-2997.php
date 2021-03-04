<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2997;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function (\SimpleXMLElement $xml) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', (bool) $xml->Exists);
};
