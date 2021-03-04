<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast;

use Closure;
use TenantCloud\BetterReflection\Relocated\PhpParser\Parser;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource;
use Throwable;
use function strtolower;
/**
 * @internal
 */
class Locator
{
    /** @var FindReflectionsInTree */
    private $findReflectionsInTree;
    /** @var Parser */
    private $parser;
    /**
     * @param Closure(): FunctionReflector $functionReflectorGetter
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Parser $parser, \Closure $functionReflectorGetter)
    {
        $this->findReflectionsInTree = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\FindReflectionsInTree(new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection(), $functionReflectorGetter);
        $this->parser = $parser;
    }
    /**
     * @throws IdentifierNotFound
     * @throws Exception\ParseToAstFailure
     */
    public function findReflection(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier $identifier) : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection
    {
        return $this->findInArray($this->findReflectionsOfType($reflector, $locatedSource, $identifier->getType()), $identifier);
    }
    /**
     * Get an array of reflections found in some code.
     *
     * @return Reflection[]
     *
     * @throws Exception\ParseToAstFailure
     */
    public function findReflectionsOfType(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        try {
            return $this->findReflectionsInTree->__invoke($reflector, $this->parser->parse($locatedSource->getSource()), $identifierType, $locatedSource);
        } catch (\Throwable $exception) {
            throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Exception\ParseToAstFailure::fromLocatedSource($locatedSource, $exception);
        }
    }
    /**
     * Given an array of Reflections, try to find the identifier.
     *
     * @param Reflection[] $reflections
     *
     * @throws IdentifierNotFound
     */
    private function findInArray(array $reflections, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier $identifier) : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection
    {
        $identifierName = \strtolower($identifier->getName());
        foreach ($reflections as $reflection) {
            if (\strtolower($reflection->getName()) === $identifierName) {
                return $reflection;
            }
        }
        throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound::fromIdentifier($identifier);
    }
}
