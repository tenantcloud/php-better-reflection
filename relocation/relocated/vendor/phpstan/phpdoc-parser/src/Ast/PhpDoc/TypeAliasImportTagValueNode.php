<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
class TypeAliasImportTagValueNode implements \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    /** @var string */
    public $importedAlias;
    /** @var IdentifierTypeNode */
    public $importedFrom;
    /** @var string|null */
    public $importedAs;
    public function __construct(string $importedAlias, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $importedFrom, ?string $importedAs)
    {
        $this->importedAlias = $importedAlias;
        $this->importedFrom = $importedFrom;
        $this->importedAs = $importedAs;
    }
    public function __toString() : string
    {
        return \trim("{$this->importedAlias} from {$this->importedFrom}" . ($this->importedAs !== null ? " as {$this->importedAs}" : ''));
    }
}
