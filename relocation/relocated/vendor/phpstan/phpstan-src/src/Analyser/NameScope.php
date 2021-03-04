<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class NameScope
{
    private ?string $namespace;
    /** @var array<string, string> alias(string) => fullName(string) */
    private array $uses;
    private ?string $className;
    private ?string $functionName;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap;
    /**
     * @param string|null $namespace
     * @param array<string, string> $uses alias(string) => fullName(string)
     * @param string|null $className
     */
    public function __construct(?string $namespace, array $uses, ?string $className = null, ?string $functionName = null, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap = null)
    {
        $this->namespace = $namespace;
        $this->uses = $uses;
        $this->className = $className;
        $this->functionName = $functionName;
        $this->templateTypeMap = $templateTypeMap ?? \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getNamespace() : ?string
    {
        return $this->namespace;
    }
    /**
     * @return array<string, string>
     */
    public function getUses() : array
    {
        return $this->uses;
    }
    public function getClassName() : ?string
    {
        return $this->className;
    }
    public function resolveStringName(string $name) : string
    {
        if (\strpos($name, '\\') === 0) {
            return \ltrim($name, '\\');
        }
        $nameParts = \explode('\\', $name);
        $firstNamePart = \strtolower($nameParts[0]);
        if (isset($this->uses[$firstNamePart])) {
            if (\count($nameParts) === 1) {
                return $this->uses[$firstNamePart];
            }
            \array_shift($nameParts);
            return \sprintf('%s\\%s', $this->uses[$firstNamePart], \implode('\\', $nameParts));
        }
        if ($this->namespace !== null) {
            return \sprintf('%s\\%s', $this->namespace, $name);
        }
        return $name;
    }
    public function getTemplateTypeScope() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope
    {
        if ($this->className !== null) {
            if ($this->functionName !== null) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithMethod($this->className, $this->functionName);
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithClass($this->className);
        }
        if ($this->functionName !== null) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction($this->functionName);
        }
        return null;
    }
    public function getTemplateTypeMap() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        return $this->templateTypeMap;
    }
    public function resolveTemplateTypeName(string $name) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->templateTypeMap->getType($name);
    }
    public function withTemplateTypeMap(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $map) : self
    {
        return new self($this->namespace, $this->uses, $this->className, $this->functionName, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap(\array_merge($this->templateTypeMap->getTypes(), $map->getTypes())));
    }
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : self
    {
        return new self($properties['namespace'], $properties['uses'], $properties['className'], $properties['functionName'], $properties['templateTypeMap']);
    }
}
