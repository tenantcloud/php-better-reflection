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

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type;
/**
 * Represents a collection type as described in the PSR-5, the PHPDoc Standard.
 *
 * A collection can be represented in two forms:
 *
 * 1. `ACollectionObject<aValueType>`
 * 2. `ACollectionObject<aValueType,aKeyType>`
 *
 * - ACollectionObject can be 'array' or an object that can act as an array
 * - aValueType and aKeyType can be any type expression
 *
 * @psalm-immutable
 */
final class Collection extends \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\AbstractList
{
    /** @var Fqsen|null */
    private $fqsen;
    /**
     * Initializes this representation of an array with the given Type or Fqsen.
     */
    public function __construct(?\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen $fqsen, \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type $valueType, ?\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type $keyType = null)
    {
        parent::__construct($valueType, $keyType);
        $this->fqsen = $fqsen;
    }
    /**
     * Returns the FQSEN associated with this object.
     */
    public function getFqsen() : ?\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen
    {
        return $this->fqsen;
    }
    /**
     * Returns a rendered output of the Type as it would be used in a DocBlock.
     */
    public function __toString() : string
    {
        $objectType = (string) ($this->fqsen ?? 'object');
        if ($this->keyType === null) {
            return $objectType . '<' . $this->valueType . '>';
        }
        return $objectType . '<' . $this->keyType . ',' . $this->valueType . '>';
    }
}
