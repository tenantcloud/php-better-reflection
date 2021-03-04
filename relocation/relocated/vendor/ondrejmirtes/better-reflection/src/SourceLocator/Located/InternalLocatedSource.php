<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located;

class InternalLocatedSource extends \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource
{
    /** @var string */
    private $extensionName;
    /**
     * {@inheritDoc}
     */
    public function __construct(string $source, string $extensionName, ?string $fileName = null)
    {
        parent::__construct($source, $fileName);
        $this->extensionName = $extensionName;
    }
    public function isInternal() : bool
    {
        return \true;
    }
    public function getExtensionName() : ?string
    {
        return $this->extensionName;
    }
}
