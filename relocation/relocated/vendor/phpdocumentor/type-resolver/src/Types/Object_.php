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

use InvalidArgumentException;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type;
use function strpos;
/**
 * Value Object representing an object.
 *
 * An object can be either typed or untyped. When an object is typed it means that it has an identifier, the FQSEN,
 * pointing to an element in PHP. Object types that are untyped do not refer to a specific class but represent objects
 * in general.
 *
 * @psalm-immutable
 */
final class Object_ implements \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type
{
    /** @var Fqsen|null */
    private $fqsen;
    /**
     * Initializes this object with an optional FQSEN, if not provided this object is considered 'untyped'.
     *
     * @throws InvalidArgumentException When provided $fqsen is not a valid type.
     */
    public function __construct(?\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen $fqsen = null)
    {
        if (\strpos((string) $fqsen, '::') !== \false || \strpos((string) $fqsen, '()') !== \false) {
            throw new \InvalidArgumentException('Object types can only refer to a class, interface or trait but a method, function, constant or ' . 'property was received: ' . (string) $fqsen);
        }
        $this->fqsen = $fqsen;
    }
    /**
     * Returns the FQSEN associated with this object.
     */
    public function getFqsen() : ?\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Fqsen
    {
        return $this->fqsen;
    }
    public function __toString() : string
    {
        if ($this->fqsen) {
            return (string) $this->fqsen;
        }
        return 'object';
    }
}
