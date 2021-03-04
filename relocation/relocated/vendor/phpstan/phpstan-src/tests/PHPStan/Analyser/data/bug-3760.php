<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Bug3760;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class HelloWorld
{
    /**
     * Whether the type allows covariant matches
     *
     * @var bool
     */
    public $allowsCovariance;
    /**
     * Whether the type allows contravariant matches
     *
     * @var bool
     */
    public $allowsContravariance;
    /**
     * @param bool $allowsCovariance
     * @param bool $allowsContravariance
     */
    protected function __construct($allowsCovariance, $allowsContravariance)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $allowsCovariance);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $allowsCovariance);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $allowsContravariance);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $allowsContravariance);
        $this->allowsCovariance = (bool) $allowsCovariance;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $allowsCovariance);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $allowsCovariance);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $allowsContravariance);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $allowsContravariance);
        $this->allowsContravariance = (bool) $allowsContravariance;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $allowsCovariance);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $allowsCovariance);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $allowsContravariance);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $allowsContravariance);
    }
}
