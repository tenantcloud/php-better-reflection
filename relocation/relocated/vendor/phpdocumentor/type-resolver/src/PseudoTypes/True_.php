<?php

declare (strict_types=1);
/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link https://phpdoc.org
 */
namespace TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\PseudoTypes;

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\PseudoType;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean;
use function class_alias;
/**
 * Value Object representing the PseudoType 'False', which is a Boolean type.
 *
 * @psalm-immutable
 */
final class True_ extends \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean implements \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\PseudoType
{
    public function underlyingType() : \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Boolean();
    }
    public function __toString() : string
    {
        return 'true';
    }
}
\class_alias('TenantCloud\\BetterReflection\\Relocated\\phpDocumentor\\Reflection\\PseudoTypes\\True_', 'TenantCloud\\BetterReflection\\Relocated\\phpDocumentor\\Reflection\\Types\\True_', \false);
