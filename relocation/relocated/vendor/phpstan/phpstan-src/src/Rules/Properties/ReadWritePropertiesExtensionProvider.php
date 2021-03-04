<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

interface ReadWritePropertiesExtensionProvider
{
    public const EXTENSION_TAG = 'phpstan.properties.readWriteExtension';
    /**
     * @return ReadWritePropertiesExtension[]
     */
    public function getExtensions() : array;
}
