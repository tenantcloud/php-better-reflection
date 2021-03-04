<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

class DirectReadWritePropertiesExtensionProvider implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\ReadWritePropertiesExtensionProvider
{
    /** @var ReadWritePropertiesExtension[] */
    private $extensions;
    /**
     * @param ReadWritePropertiesExtension[] $extensions
     */
    public function __construct(array $extensions)
    {
        $this->extensions = $extensions;
    }
    /**
     * @return ReadWritePropertiesExtension[]
     */
    public function getExtensions() : array
    {
        return $this->extensions;
    }
}
