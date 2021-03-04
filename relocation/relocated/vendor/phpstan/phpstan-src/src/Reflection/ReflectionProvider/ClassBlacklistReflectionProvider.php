<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;

use TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GlobalConstantReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionWithFilename;
class ClassBlacklistReflectionProvider implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpStormStubsSourceStubber;
    /** @var string[] */
    private array $patterns;
    private ?string $singleReflectionFile;
    /**
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param string[] $patterns
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpStormStubsSourceStubber, array $patterns, ?string $singleReflectionFile)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->phpStormStubsSourceStubber = $phpStormStubsSourceStubber;
        $this->patterns = $patterns;
        $this->singleReflectionFile = $singleReflectionFile;
    }
    public function hasClass(string $className) : bool
    {
        if ($this->isClassBlacklisted($className)) {
            return \false;
        }
        $has = $this->reflectionProvider->hasClass($className);
        if (!$has) {
            return \false;
        }
        $classReflection = $this->reflectionProvider->getClass($className);
        if ($this->singleReflectionFile !== null) {
            if ($classReflection->getFileName() === $this->singleReflectionFile) {
                return \false;
            }
        }
        foreach ($classReflection->getParentClassesNames() as $parentClassName) {
            if ($this->isClassBlacklisted($parentClassName)) {
                return \false;
            }
        }
        foreach ($classReflection->getNativeReflection()->getInterfaceNames() as $interfaceName) {
            if ($this->isClassBlacklisted($interfaceName)) {
                return \false;
            }
        }
        return \true;
    }
    private function isClassBlacklisted(string $className) : bool
    {
        if ($this->phpStormStubsSourceStubber->hasClass($className)) {
            // check that userland class isn't aliased to the same name as a class from stubs
            if (!\class_exists($className, \false)) {
                return \true;
            }
            if (\in_array(\strtolower($className), ['reflectionuniontype', 'attribute'], \true)) {
                return \true;
            }
            $reflection = new \ReflectionClass($className);
            if ($reflection->getFileName() === \false) {
                return \true;
            }
        }
        foreach ($this->patterns as $pattern) {
            if (\TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::match($className, $pattern) !== null) {
                return \true;
            }
        }
        return \false;
    }
    public function getClass(string $className) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        if (!$this->hasClass($className)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassNotFoundException($className);
        }
        return $this->reflectionProvider->getClass($className);
    }
    public function getClassName(string $className) : string
    {
        if (!$this->hasClass($className)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassNotFoundException($className);
        }
        return $this->reflectionProvider->getClassName($className);
    }
    public function supportsAnonymousClasses() : bool
    {
        return \false;
    }
    public function getAnonymousClassReflection(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_ $classNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
    }
    public function hasFunction(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : bool
    {
        $has = $this->reflectionProvider->hasFunction($nameNode, $scope);
        if (!$has) {
            return \false;
        }
        if ($this->singleReflectionFile === null) {
            return \true;
        }
        $functionReflection = $this->reflectionProvider->getFunction($nameNode, $scope);
        if (!$functionReflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionWithFilename) {
            return \true;
        }
        return $functionReflection->getFileName() !== $this->singleReflectionFile;
    }
    public function getFunction(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection
    {
        return $this->reflectionProvider->getFunction($nameNode, $scope);
    }
    public function resolveFunctionName(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->reflectionProvider->resolveFunctionName($nameNode, $scope);
    }
    public function hasConstant(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->reflectionProvider->hasConstant($nameNode, $scope);
    }
    public function getConstant(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GlobalConstantReflection
    {
        return $this->reflectionProvider->getConstant($nameNode, $scope);
    }
    public function resolveConstantName(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->reflectionProvider->resolveConstantName($nameNode, $scope);
    }
}
