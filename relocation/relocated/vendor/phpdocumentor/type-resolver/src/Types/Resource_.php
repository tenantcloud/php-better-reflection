<?php

declare (strict_types=1);
/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      http://phpdoc.org
 */
namespace TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types;

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type;
/**
 * Value Object representing the 'resource' Type.
 *
 * @psalm-immutable
 */
final class Resource_ implements \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type
{
    /**
     * Returns a rendered output of the Type as it would be used in a DocBlock.
     */
    public function __toString() : string
    {
        return 'resource';
    }
}
