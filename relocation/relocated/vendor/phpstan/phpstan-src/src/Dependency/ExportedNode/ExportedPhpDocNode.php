<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\ExportedNode;

use JsonSerializable;
use TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\ExportedNode;
class ExportedPhpDocNode implements \TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\ExportedNode, \JsonSerializable
{
    private string $phpDocString;
    private ?string $namespace;
    /** @var array<string, string> alias(string) => fullName(string) */
    private array $uses;
    /**
     * @param string $phpDocString
     * @param string|null $namespace
     * @param array<string, string> $uses
     */
    public function __construct(string $phpDocString, ?string $namespace, array $uses)
    {
        $this->phpDocString = $phpDocString;
        $this->namespace = $namespace;
        $this->uses = $uses;
    }
    public function equals(\TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\ExportedNode $node) : bool
    {
        if (!$node instanceof self) {
            return \false;
        }
        return $this->phpDocString === $node->phpDocString && $this->namespace === $node->namespace && $this->uses === $node->uses;
    }
    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return ['type' => self::class, 'data' => ['phpDocString' => $this->phpDocString, 'namespace' => $this->namespace, 'uses' => $this->uses]];
    }
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : \TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\ExportedNode
    {
        return new self($properties['phpDocString'], $properties['namespace'], $properties['uses']);
    }
    /**
     * @param mixed[] $data
     * @return self
     */
    public static function decode(array $data) : \TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\ExportedNode
    {
        return new self($data['phpDocString'], $data['namespace'], $data['uses']);
    }
}
