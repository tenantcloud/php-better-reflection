<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Declare_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_;
use TenantCloud\BetterReflection\Relocated\PHPStan\Cache\Cache;
use TenantCloud\BetterReflection\Relocated\PHPStan\Parser\FunctionCallStatementFinder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionVariantWithPhpDocs;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodPrototypeReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorWithPhpDocs;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypehintHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType;
class PhpMethodReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringTrait;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\BuiltinMethodReflection $reflection;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Cache\Cache $cache;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap;
    /** @var \PHPStan\Type\Type[] */
    private array $phpDocParameterTypes;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocReturnType;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocThrowType;
    /** @var \PHPStan\Reflection\Php\PhpParameterReflection[]|null */
    private ?array $parameters = null;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $returnType = null;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $nativeReturnType = null;
    private ?string $deprecatedDescription;
    private bool $isDeprecated;
    private bool $isInternal;
    private bool $isFinal;
    private ?bool $isPure;
    private ?string $stubPhpDocString;
    /** @var FunctionVariantWithPhpDocs[]|null */
    private ?array $variants = null;
    /**
     * @param ClassReflection $declaringClass
     * @param ClassReflection|null $declaringTrait
     * @param BuiltinMethodReflection $reflection
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param Parser $parser
     * @param FunctionCallStatementFinder $functionCallStatementFinder
     * @param Cache $cache
     * @param \PHPStan\Type\Type[] $phpDocParameterTypes
     * @param Type|null $phpDocReturnType
     * @param Type|null $phpDocThrowType
     * @param string|null $deprecatedDescription
     * @param bool $isDeprecated
     * @param bool $isInternal
     * @param bool $isFinal
     * @param string|null $stubPhpDocString
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringTrait, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\BuiltinMethodReflection $reflection, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser, \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \TenantCloud\BetterReflection\Relocated\PHPStan\Cache\Cache $cache, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocReturnType, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, ?string $stubPhpDocString, ?bool $isPure = null)
    {
        $this->declaringClass = $declaringClass;
        $this->declaringTrait = $declaringTrait;
        $this->reflection = $reflection;
        $this->reflectionProvider = $reflectionProvider;
        $this->parser = $parser;
        $this->functionCallStatementFinder = $functionCallStatementFinder;
        $this->cache = $cache;
        $this->templateTypeMap = $templateTypeMap;
        $this->phpDocParameterTypes = $phpDocParameterTypes;
        $this->phpDocReturnType = $phpDocReturnType;
        $this->phpDocThrowType = $phpDocThrowType;
        $this->deprecatedDescription = $deprecatedDescription;
        $this->isDeprecated = $isDeprecated;
        $this->isInternal = $isInternal;
        $this->isFinal = $isFinal;
        $this->stubPhpDocString = $stubPhpDocString;
        $this->isPure = $isPure;
    }
    public function getDeclaringClass() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function getDeclaringTrait() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringTrait;
    }
    public function getDocComment() : ?string
    {
        if ($this->stubPhpDocString !== null) {
            return $this->stubPhpDocString;
        }
        return $this->reflection->getDocComment();
    }
    /**
     * @return self|\PHPStan\Reflection\MethodPrototypeReflection
     */
    public function getPrototype() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberReflection
    {
        try {
            $prototypeMethod = $this->reflection->getPrototype();
            $prototypeDeclaringClass = $this->reflectionProvider->getClass($prototypeMethod->getDeclaringClass()->getName());
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodPrototypeReflection($prototypeMethod->getName(), $prototypeDeclaringClass, $prototypeMethod->isStatic(), $prototypeMethod->isPrivate(), $prototypeMethod->isPublic(), $prototypeMethod->isAbstract(), $prototypeMethod->isFinal(), $prototypeDeclaringClass->getNativeMethod($prototypeMethod->getName())->getVariants());
        } catch (\ReflectionException $e) {
            return $this;
        }
    }
    public function isStatic() : bool
    {
        return $this->reflection->isStatic();
    }
    public function getName() : string
    {
        $name = $this->reflection->getName();
        $lowercaseName = \strtolower($name);
        if ($lowercaseName === $name) {
            // fix for https://bugs.php.net/bug.php?id=74939
            foreach ($this->getDeclaringClass()->getNativeReflection()->getTraitAliases() as $traitTarget) {
                $correctName = $this->getMethodNameWithCorrectCase($name, $traitTarget);
                if ($correctName !== null) {
                    $name = $correctName;
                    break;
                }
            }
        }
        return $name;
    }
    private function getMethodNameWithCorrectCase(string $lowercaseMethodName, string $traitTarget) : ?string
    {
        $trait = \explode('::', $traitTarget)[0];
        $traitReflection = $this->reflectionProvider->getClass($trait)->getNativeReflection();
        foreach ($traitReflection->getTraitAliases() as $methodAlias => $aliasTraitTarget) {
            if ($lowercaseMethodName === \strtolower($methodAlias)) {
                return $methodAlias;
            }
            $correctName = $this->getMethodNameWithCorrectCase($lowercaseMethodName, $aliasTraitTarget);
            if ($correctName !== null) {
                return $correctName;
            }
        }
        return null;
    }
    /**
     * @return ParametersAcceptorWithPhpDocs[]
     */
    public function getVariants() : array
    {
        if ($this->variants === null) {
            $this->variants = [new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionVariantWithPhpDocs($this->templateTypeMap, null, $this->getParameters(), $this->isVariadic(), $this->getReturnType(), $this->getPhpDocReturnType(), $this->getNativeReturnType())];
        }
        return $this->variants;
    }
    /**
     * @return \PHPStan\Reflection\ParameterReflectionWithPhpDocs[]
     */
    private function getParameters() : array
    {
        if ($this->parameters === null) {
            $this->parameters = \array_map(function (\ReflectionParameter $reflection) : PhpParameterReflection {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpParameterReflection($reflection, $this->phpDocParameterTypes[$reflection->getName()] ?? null, $this->getDeclaringClass()->getName());
            }, $this->reflection->getParameters());
        }
        return $this->parameters;
    }
    private function isVariadic() : bool
    {
        $isNativelyVariadic = $this->reflection->isVariadic();
        $declaringClass = $this->declaringClass;
        $filename = $this->declaringClass->getFileName();
        if ($this->declaringTrait !== null) {
            $declaringClass = $this->declaringTrait;
            $filename = $this->declaringTrait->getFileName();
        }
        if (!$isNativelyVariadic && $filename !== \false && \file_exists($filename)) {
            $modifiedTime = \filemtime($filename);
            if ($modifiedTime === \false) {
                $modifiedTime = \time();
            }
            $key = \sprintf('variadic-method-%s-%s-%s', $declaringClass->getName(), $this->reflection->getName(), $filename);
            $variableCacheKey = \sprintf('%d-v2', $modifiedTime);
            $cachedResult = $this->cache->load($key, $variableCacheKey);
            if ($cachedResult === null || !\is_bool($cachedResult)) {
                $nodes = $this->parser->parseFile($filename);
                $result = $this->callsFuncGetArgs($declaringClass, $nodes);
                $this->cache->save($key, $variableCacheKey, $result);
                return $result;
            }
            return $cachedResult;
        }
        return $isNativelyVariadic;
    }
    /**
     * @param ClassReflection $declaringClass
     * @param \PhpParser\Node[] $nodes
     * @return bool
     */
    private function callsFuncGetArgs(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass, array $nodes) : bool
    {
        foreach ($nodes as $node) {
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike) {
                if (!isset($node->namespacedName)) {
                    continue;
                }
                if ($declaringClass->getName() !== (string) $node->namespacedName) {
                    continue;
                }
                if ($this->callsFuncGetArgs($declaringClass, $node->stmts)) {
                    return \true;
                }
                continue;
            }
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod) {
                if ($node->getStmts() === null) {
                    continue;
                    // interface
                }
                $methodName = $node->name->name;
                if ($methodName === $this->reflection->getName()) {
                    return $this->functionCallStatementFinder->findFunctionCallInStatements(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor::VARIADIC_FUNCTIONS, $node->getStmts()) !== null;
                }
                continue;
            }
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_) {
                continue;
            }
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_) {
                if ($this->callsFuncGetArgs($declaringClass, $node->stmts)) {
                    return \true;
                }
                continue;
            }
            if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Declare_ || $node->stmts === null) {
                continue;
            }
            if ($this->callsFuncGetArgs($declaringClass, $node->stmts)) {
                return \true;
            }
        }
        return \false;
    }
    public function isPrivate() : bool
    {
        return $this->reflection->isPrivate();
    }
    public function isPublic() : bool
    {
        return $this->reflection->isPublic();
    }
    private function getReturnType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->returnType === null) {
            $name = \strtolower($this->getName());
            if ($name === '__construct' || $name === '__destruct' || $name === '__unset' || $name === '__wakeup' || $name === '__clone') {
                return $this->returnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypehintHelper::decideType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType(), $this->phpDocReturnType);
            }
            if ($name === '__tostring') {
                return $this->returnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypehintHelper::decideType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), $this->phpDocReturnType);
            }
            if ($name === '__isset') {
                return $this->returnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypehintHelper::decideType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), $this->phpDocReturnType);
            }
            if ($name === '__sleep') {
                return $this->returnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypehintHelper::decideType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()), $this->phpDocReturnType);
            }
            if ($name === '__set_state') {
                return $this->returnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypehintHelper::decideType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), $this->phpDocReturnType);
            }
            $this->returnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getReturnType(), $this->phpDocReturnType, $this->declaringClass->getName());
        }
        return $this->returnType;
    }
    private function getPhpDocReturnType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->phpDocReturnType !== null) {
            return $this->phpDocReturnType;
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
    }
    private function getNativeReturnType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->nativeReturnType === null) {
            $this->nativeReturnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getReturnType(), null, $this->declaringClass->getName());
        }
        return $this->nativeReturnType;
    }
    public function getDeprecatedDescription() : ?string
    {
        if ($this->isDeprecated) {
            return $this->deprecatedDescription;
        }
        return null;
    }
    public function isDeprecated() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated()->or(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($this->isDeprecated));
    }
    public function isInternal() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($this->reflection->isInternal() || $this->isInternal);
    }
    public function isFinal() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($this->reflection->isFinal() || $this->isFinal);
    }
    public function isAbstract() : bool
    {
        return $this->reflection->isAbstract();
    }
    public function getThrowType() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->phpDocThrowType;
    }
    public function hasSideEffects() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $name = \strtolower($this->getName());
        $isVoid = $this->getReturnType() instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType;
        if ($name !== '__construct' && $isVoid) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        if ($this->isPure !== null) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean(!$this->isPure);
        }
        if ($isVoid) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
    }
}
