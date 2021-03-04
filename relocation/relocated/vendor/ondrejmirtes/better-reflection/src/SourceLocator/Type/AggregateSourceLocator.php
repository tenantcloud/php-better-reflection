<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector;
use function array_map;
use function array_merge;
class AggregateSourceLocator implements \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var SourceLocator[] */
    private $sourceLocators;
    /**
     * @param SourceLocator[] $sourceLocators
     */
    public function __construct(array $sourceLocators = [])
    {
        // This slightly confusing code simply type-checks the $sourceLocators
        // array by unpacking them and splatting them in the closure.
        $validator = static function (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator ...$sourceLocator) : array {
            return $sourceLocator;
        };
        $this->sourceLocators = $validator(...$sourceLocators);
    }
    public function locateIdentifier(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier $identifier) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection
    {
        foreach ($this->sourceLocators as $sourceLocator) {
            $located = $sourceLocator->locateIdentifier($reflector, $identifier);
            if ($located) {
                return $located;
            }
        }
        return null;
    }
    /**
     * {@inheritDoc}
     */
    public function locateIdentifiersByType(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return \array_merge([], ...\array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator) use($reflector, $identifierType) {
            return $sourceLocator->locateIdentifiersByType($reflector, $identifierType);
        }, $this->sourceLocators));
    }
}
