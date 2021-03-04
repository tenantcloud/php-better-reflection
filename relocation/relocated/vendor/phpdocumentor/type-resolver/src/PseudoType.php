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
namespace TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection;

interface PseudoType extends \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type
{
    public function underlyingType() : \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type;
}
