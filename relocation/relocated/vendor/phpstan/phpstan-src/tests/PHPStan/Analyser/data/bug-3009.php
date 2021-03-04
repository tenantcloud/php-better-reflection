<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3009;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class HelloWorld
{
    public function createRedirectRequest(string $redirectUri) : ?string
    {
        $redirectUrlParts = \parse_url($redirectUri);
        if (\false === \is_array($redirectUrlParts) || \true === \array_key_exists('host', $redirectUrlParts)) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(?\'scheme\' => string, ?\'host\' => string, ?\'port\' => int, ?\'user\' => string, ?\'pass\' => string, ?\'path\' => string, ?\'query\' => string, ?\'fragment\' => string)|false', $redirectUrlParts);
            return null;
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(?\'scheme\' => string, ?\'host\' => string, ?\'port\' => int, ?\'user\' => string, ?\'pass\' => string, ?\'path\' => string, ?\'query\' => string, ?\'fragment\' => string)', $redirectUrlParts);
        if (\true === \array_key_exists('query', $redirectUrlParts)) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(?\'scheme\' => string, ?\'host\' => string, ?\'port\' => int, ?\'user\' => string, ?\'pass\' => string, ?\'path\' => string, \'query\' => string, ?\'fragment\' => string)', $redirectUrlParts);
            $redirectServer['QUERY_STRING'] = $redirectUrlParts['query'];
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(?\'scheme\' => string, ?\'host\' => string, ?\'port\' => int, ?\'user\' => string, ?\'pass\' => string, ?\'path\' => string, ?\'query\' => string, ?\'fragment\' => string)', $redirectUrlParts);
        return 'foo';
    }
}
