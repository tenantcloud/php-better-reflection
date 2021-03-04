<?php

namespace TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection;

interface DocBlockFactoryInterface
{
    /**
     * Factory method for easy instantiation.
     *
     * @param string[] $additionalTags
     *
     * @return DocBlockFactory
     */
    public static function createInstance(array $additionalTags = []);
    /**
     * @param string $docblock
     * @param Types\Context $context
     * @param Location $location
     *
     * @return DocBlock
     */
    public function create($docblock, \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context $context = null, \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Location $location = null);
}
