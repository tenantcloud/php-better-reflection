<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeAlias;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolverExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeStringResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use function array_key_exists;
class TypeAliasesTypeNodeResolverExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolverExtension
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeStringResolver $typeStringResolver;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    /** @var array<string, string> */
    private array $aliases;
    /** @var array<string, Type> */
    private array $resolvedTypes = [];
    /** @var array<string, true> */
    private array $inProcess = [];
    /**
     * @param TypeStringResolver $typeStringResolver
     * @param ReflectionProvider $reflectionProvider
     * @param array<string, string> $aliases
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeStringResolver $typeStringResolver, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $aliases)
    {
        $this->typeStringResolver = $typeStringResolver;
        $this->reflectionProvider = $reflectionProvider;
        $this->aliases = $aliases;
    }
    public function resolve(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($typeNode instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            $aliasName = $typeNode->name;
            if (\array_key_exists($aliasName, $this->resolvedTypes)) {
                return $this->resolvedTypes[$aliasName];
            }
            if (!\array_key_exists($aliasName, $this->aliases)) {
                return null;
            }
            if ($this->reflectionProvider->hasClass($aliasName)) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException(\sprintf('Type alias %s already exists as a class.', $aliasName));
            }
            if (\array_key_exists($aliasName, $this->inProcess)) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException(\sprintf('Circular definition for type alias %s.', $aliasName));
            }
            $this->inProcess[$aliasName] = \true;
            $aliasTypeString = $this->aliases[$aliasName];
            $aliasType = $this->typeStringResolver->resolve($aliasTypeString);
            $this->resolvedTypes[$aliasName] = $aliasType;
            unset($this->inProcess[$aliasName]);
            return $aliasType;
        }
        return null;
    }
}
