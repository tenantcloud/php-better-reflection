<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\TypesFinder;

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context;
class ResolveTypes
{
    /** @var TypeResolver */
    private $typeResolver;
    public function __construct()
    {
        $this->typeResolver = new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\TypeResolver();
    }
    /**
     * @param string[] $stringTypes
     *
     * @return Type[]
     */
    public function __invoke(array $stringTypes, \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context $context) : array
    {
        $resolvedTypes = [];
        foreach ($stringTypes as $stringType) {
            $resolvedTypes[] = $this->typeResolver->resolve($stringType, $context);
        }
        return $resolvedTypes;
    }
}
