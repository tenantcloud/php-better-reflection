<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection;

use Closure;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\FunctionLike as FunctionNode;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ as NamespaceNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\BetterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\Exception\NotImplemented;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\FunctionDoesNotExist;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\StringCast\ReflectionFunctionStringCast;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\ClosureSourceLocator;
use function function_exists;
class ReflectionFunction extends \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionFunctionAbstract implements \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection
{
    /**
     * @throws IdentifierNotFound
     */
    public static function createFromName(string $functionName) : self
    {
        return (new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\BetterReflection())->functionReflector()->reflect($functionName);
    }
    /**
     * @throws IdentifierNotFound
     */
    public static function createFromClosure(\Closure $closure) : self
    {
        $configuration = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\BetterReflection();
        return (new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector(new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\ClosureSourceLocator($closure, $configuration->phpParser()), $configuration->classReflector()))->reflect(self::CLOSURE_NAME);
    }
    public function __toString() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\StringCast\ReflectionFunctionStringCast::toString($this);
    }
    /**
     * @internal
     *
     * @param Node\Stmt\ClassMethod|Node\Stmt\Function_|Node\Expr\Closure $node Node has to be processed by the PhpParser\NodeVisitor\NameResolver
     */
    public static function createFromNode(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\FunctionLike $node, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ $namespaceNode = null) : self
    {
        $function = new self();
        $function->populateFunctionAbstract($reflector, $node, $locatedSource, $namespaceNode);
        return $function;
    }
    /**
     * Check to see if this function has been disabled (by the PHP INI file
     * directive `disable_functions`).
     *
     * Note - we cannot reflect on internal functions (as there is no PHP source
     * code we can access. This means, at present, we can only EVER return false
     * from this function, because you cannot disable user-defined functions.
     *
     * @see https://php.net/manual/en/ini.core.php#ini.disable-functions
     *
     * @todo https://github.com/Roave/BetterReflection/issues/14
     */
    public function isDisabled() : bool
    {
        return \false;
    }
    /**
     * @throws NotImplemented
     * @throws FunctionDoesNotExist
     */
    public function getClosure() : \Closure
    {
        $this->assertIsNoClosure();
        $functionName = $this->getName();
        $this->assertFunctionExist($functionName);
        return static function (...$args) use($functionName) {
            return $functionName(...$args);
        };
    }
    /**
     * @param mixed ...$args
     *
     * @return mixed
     *
     * @throws NotImplemented
     * @throws FunctionDoesNotExist
     */
    public function invoke(...$args)
    {
        return $this->invokeArgs($args);
    }
    /**
     * @param mixed[] $args
     *
     * @return mixed
     *
     * @throws NotImplemented
     * @throws FunctionDoesNotExist
     */
    public function invokeArgs(array $args = [])
    {
        $this->assertIsNoClosure();
        $functionName = $this->getName();
        $this->assertFunctionExist($functionName);
        return $functionName(...$args);
    }
    /**
     * @throws NotImplemented
     */
    private function assertIsNoClosure() : void
    {
        if ($this->isClosure()) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\Exception\NotImplemented('Not implemented for closures');
        }
    }
    /**
     * @throws FunctionDoesNotExist
     *
     * @psalm-assert callable-string $functionName
     */
    private function assertFunctionExist(string $functionName) : void
    {
        if (!\function_exists($functionName)) {
            throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\FunctionDoesNotExist::fromName($functionName);
        }
    }
}
