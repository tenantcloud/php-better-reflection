<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator;

use TenantCloud\BetterReflection\Relocated\Nette;
use TenantCloud\BetterReflection\Relocated\PhpParser;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\ParserFactory;
/**
 * Creates a representation based on reflection.
 */
final class Factory
{
    use Nette\SmartObject;
    public function fromClassReflection(\ReflectionClass $from, bool $withBodies = \false) : \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType
    {
        $class = $from->isAnonymous() ? new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType() : new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType($from->getShortName(), new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\PhpNamespace($from->getNamespaceName()));
        $class->setType($from->isInterface() ? $class::TYPE_INTERFACE : ($from->isTrait() ? $class::TYPE_TRAIT : $class::TYPE_CLASS));
        $class->setFinal($from->isFinal() && $class->isClass());
        $class->setAbstract($from->isAbstract() && $class->isClass());
        $ifaces = $from->getInterfaceNames();
        foreach ($ifaces as $iface) {
            $ifaces = \array_filter($ifaces, function (string $item) use($iface) : bool {
                return !\is_subclass_of($iface, $item);
            });
        }
        $class->setImplements($ifaces);
        $class->setComment(\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::unformatDocComment((string) $from->getDocComment()));
        $class->setAttributes(self::getAttributes($from));
        if ($from->getParentClass()) {
            $class->setExtends($from->getParentClass()->name);
            $class->setImplements(\array_diff($class->getImplements(), $from->getParentClass()->getInterfaceNames()));
        }
        $props = $methods = $consts = [];
        foreach ($from->getProperties() as $prop) {
            if ($prop->isDefault() && $prop->getDeclaringClass()->name === $from->name && (\PHP_VERSION_ID < 80000 || !$prop->isPromoted())) {
                $props[] = $this->fromPropertyReflection($prop);
            }
        }
        $class->setProperties($props);
        $bodies = [];
        foreach ($from->getMethods() as $method) {
            if ($method->getDeclaringClass()->name === $from->name) {
                $methods[] = $m = $this->fromMethodReflection($method);
                if ($withBodies) {
                    $srcMethod = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Reflection::getMethodDeclaringMethod($method);
                    $srcClass = $srcMethod->getDeclaringClass()->name;
                    $b = $bodies[$srcClass] = $bodies[$srcClass] ?? $this->loadMethodBodies($srcMethod->getDeclaringClass());
                    if (isset($b[$srcMethod->name])) {
                        $m->setBody($b[$srcMethod->name]);
                    }
                }
            }
        }
        $class->setMethods($methods);
        foreach ($from->getReflectionConstants() as $const) {
            if ($const->getDeclaringClass()->name === $from->name) {
                $consts[] = $this->fromConstantReflection($const);
            }
        }
        $class->setConstants($consts);
        return $class;
    }
    public function fromMethodReflection(\ReflectionMethod $from) : \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Method
    {
        $method = new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Method($from->name);
        $method->setParameters(\array_map([$this, 'fromParameterReflection'], $from->getParameters()));
        $method->setStatic($from->isStatic());
        $isInterface = $from->getDeclaringClass()->isInterface();
        $method->setVisibility($from->isPrivate() ? \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType::VISIBILITY_PRIVATE : ($from->isProtected() ? \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType::VISIBILITY_PROTECTED : ($isInterface ? null : \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType::VISIBILITY_PUBLIC)));
        $method->setFinal($from->isFinal());
        $method->setAbstract($from->isAbstract() && !$isInterface);
        $method->setBody($from->isAbstract() ? null : '');
        $method->setReturnReference($from->returnsReference());
        $method->setVariadic($from->isVariadic());
        $method->setComment(\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::unformatDocComment((string) $from->getDocComment()));
        $method->setAttributes(self::getAttributes($from));
        if ($from->getReturnType() instanceof \ReflectionNamedType) {
            $method->setReturnType($from->getReturnType()->getName());
            $method->setReturnNullable($from->getReturnType()->allowsNull());
        } elseif ($from->getReturnType() instanceof \ReflectionUnionType) {
            $method->setReturnType((string) $from->getReturnType());
        }
        return $method;
    }
    /** @return GlobalFunction|Closure */
    public function fromFunctionReflection(\ReflectionFunction $from, bool $withBody = \false)
    {
        $function = $from->isClosure() ? new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Closure() : new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\GlobalFunction($from->name);
        $function->setParameters(\array_map([$this, 'fromParameterReflection'], $from->getParameters()));
        $function->setReturnReference($from->returnsReference());
        $function->setVariadic($from->isVariadic());
        if (!$from->isClosure()) {
            $function->setComment(\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::unformatDocComment((string) $from->getDocComment()));
        }
        $function->setAttributes(self::getAttributes($from));
        if ($from->getReturnType() instanceof \ReflectionNamedType) {
            $function->setReturnType($from->getReturnType()->getName());
            $function->setReturnNullable($from->getReturnType()->allowsNull());
        } elseif ($from->getReturnType() instanceof \ReflectionUnionType) {
            $function->setReturnType((string) $from->getReturnType());
        }
        $function->setBody($withBody ? $this->loadFunctionBody($from) : '');
        return $function;
    }
    /** @return Method|GlobalFunction|Closure */
    public function fromCallable(callable $from)
    {
        $ref = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Callback::toReflection($from);
        return $ref instanceof \ReflectionMethod ? self::fromMethodReflection($ref) : self::fromFunctionReflection($ref);
    }
    public function fromParameterReflection(\ReflectionParameter $from) : \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Parameter
    {
        $param = \PHP_VERSION_ID >= 80000 && $from->isPromoted() ? new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\PromotedParameter($from->name) : new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Parameter($from->name);
        $param->setReference($from->isPassedByReference());
        if ($from->getType() instanceof \ReflectionNamedType) {
            $param->setType($from->getType()->getName());
            $param->setNullable($from->getType()->allowsNull());
        } elseif ($from->getType() instanceof \ReflectionUnionType) {
            $param->setType((string) $from->getType());
        }
        if ($from->isDefaultValueAvailable()) {
            $param->setDefaultValue($from->isDefaultValueConstant() ? new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Literal($from->getDefaultValueConstantName()) : $from->getDefaultValue());
            $param->setNullable($param->isNullable() && $param->getDefaultValue() !== null);
        }
        $param->setAttributes(self::getAttributes($from));
        return $param;
    }
    public function fromConstantReflection(\ReflectionClassConstant $from) : \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Constant
    {
        $const = new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Constant($from->name);
        $const->setValue($from->getValue());
        $const->setVisibility($from->isPrivate() ? \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType::VISIBILITY_PRIVATE : ($from->isProtected() ? \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType::VISIBILITY_PROTECTED : \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType::VISIBILITY_PUBLIC));
        $const->setComment(\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::unformatDocComment((string) $from->getDocComment()));
        $const->setAttributes(self::getAttributes($from));
        return $const;
    }
    public function fromPropertyReflection(\ReflectionProperty $from) : \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Property
    {
        $defaults = $from->getDeclaringClass()->getDefaultProperties();
        $prop = new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Property($from->name);
        $prop->setValue($defaults[$prop->getName()] ?? null);
        $prop->setStatic($from->isStatic());
        $prop->setVisibility($from->isPrivate() ? \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType::VISIBILITY_PRIVATE : ($from->isProtected() ? \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType::VISIBILITY_PROTECTED : \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\ClassType::VISIBILITY_PUBLIC));
        if (\PHP_VERSION_ID >= 70400) {
            if ($from->getType() instanceof \ReflectionNamedType) {
                $prop->setType($from->getType()->getName());
                $prop->setNullable($from->getType()->allowsNull());
            } elseif ($from->getType() instanceof \ReflectionUnionType) {
                $prop->setType((string) $from->getType());
            }
            $prop->setInitialized($from->hasType() && \array_key_exists($prop->getName(), $defaults));
        } else {
            $prop->setInitialized(\false);
        }
        $prop->setComment(\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::unformatDocComment((string) $from->getDocComment()));
        $prop->setAttributes(self::getAttributes($from));
        return $prop;
    }
    private function loadMethodBodies(\ReflectionClass $from) : array
    {
        if ($from->isAnonymous()) {
            throw new \TenantCloud\BetterReflection\Relocated\Nette\NotSupportedException('Anonymous classes are not supported.');
        }
        [$code, $stmts] = $this->parse($from);
        $nodeFinder = new \TenantCloud\BetterReflection\Relocated\PhpParser\NodeFinder();
        $class = $nodeFinder->findFirst($stmts, function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node) use($from) {
            return ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_ || $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Trait_) && $node->namespacedName->toString() === $from->name;
        });
        $bodies = [];
        foreach ($nodeFinder->findInstanceOf($class, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod::class) as $method) {
            /** @var Node\Stmt\ClassMethod $method */
            if ($method->stmts) {
                $body = $this->extractBody($nodeFinder, $code, $method->stmts);
                $bodies[$method->name->toString()] = \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::unindent($body, 2);
            }
        }
        return $bodies;
    }
    private function loadFunctionBody(\ReflectionFunction $from) : string
    {
        if ($from->isClosure()) {
            throw new \TenantCloud\BetterReflection\Relocated\Nette\NotSupportedException('Closures are not supported.');
        }
        [$code, $stmts] = $this->parse($from);
        $nodeFinder = new \TenantCloud\BetterReflection\Relocated\PhpParser\NodeFinder();
        /** @var Node\Stmt\Function_ $function */
        $function = $nodeFinder->findFirst($stmts, function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node) use($from) {
            return $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_ && $node->namespacedName->toString() === $from->name;
        });
        $body = $this->extractBody($nodeFinder, $code, $function->stmts);
        return \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Helpers::unindent($body, 1);
    }
    /**
     * @param  Node[]  $statements
     */
    private function extractBody(\TenantCloud\BetterReflection\Relocated\PhpParser\NodeFinder $nodeFinder, string $originalCode, array $statements) : string
    {
        $start = $statements[0]->getAttribute('startFilePos');
        $body = \substr($originalCode, $start, \end($statements)->getAttribute('endFilePos') - $start + 1);
        $replacements = [];
        // name-nodes => resolved fully-qualified name
        foreach ($nodeFinder->findInstanceOf($statements, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name::class) as $node) {
            if ($node->hasAttribute('resolvedName') && $node->getAttribute('resolvedName') instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name\FullyQualified) {
                $replacements[] = [$node->getStartFilePos(), $node->getEndFilePos(), $node->getAttribute('resolvedName')->toCodeString()];
            }
        }
        // multi-line strings => singleline
        foreach (\array_merge($nodeFinder->findInstanceOf($statements, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_::class), $nodeFinder->findInstanceOf($statements, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\EncapsedStringPart::class)) as $node) {
            /** @var Node\Scalar\String_|Node\Scalar\EncapsedStringPart $node */
            $token = \substr($body, $node->getStartFilePos() - $start, $node->getEndFilePos() - $node->getStartFilePos() + 1);
            if (\strpos($token, "\n") !== \false) {
                $quote = $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_ ? '"' : '';
                $replacements[] = [$node->getStartFilePos(), $node->getEndFilePos(), $quote . \addcslashes($node->value, "\0..\37") . $quote];
            }
        }
        // HEREDOC => "string"
        foreach ($nodeFinder->findInstanceOf($statements, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\Encapsed::class) as $node) {
            /** @var Node\Scalar\Encapsed $node */
            if ($node->getAttribute('kind') === \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_::KIND_HEREDOC) {
                $replacements[] = [$node->getStartFilePos(), $node->parts[0]->getStartFilePos() - 1, '"'];
                $replacements[] = [\end($node->parts)->getEndFilePos() + 1, $node->getEndFilePos(), '"'];
            }
        }
        //sort collected resolved names by position in file
        \usort($replacements, function ($a, $b) {
            return $a[0] <=> $b[0];
        });
        $correctiveOffset = -$start;
        //replace changes body length so we need correct offset
        foreach ($replacements as [$startPos, $endPos, $replacement]) {
            $replacingStringLength = $endPos - $startPos + 1;
            $body = \substr_replace($body, $replacement, $correctiveOffset + $startPos, $replacingStringLength);
            $correctiveOffset += \strlen($replacement) - $replacingStringLength;
        }
        return $body;
    }
    private function parse($from) : array
    {
        $file = $from->getFileName();
        if (!\class_exists(\TenantCloud\BetterReflection\Relocated\PhpParser\ParserFactory::class)) {
            throw new \TenantCloud\BetterReflection\Relocated\Nette\NotSupportedException("PHP-Parser is required to load method bodies, install package 'nikic/php-parser'.");
        } elseif (!$file) {
            throw new \TenantCloud\BetterReflection\Relocated\Nette\InvalidStateException("Source code of {$from->name} not found.");
        }
        $lexer = new \TenantCloud\BetterReflection\Relocated\PhpParser\Lexer(['usedAttributes' => ['startFilePos', 'endFilePos']]);
        $parser = (new \TenantCloud\BetterReflection\Relocated\PhpParser\ParserFactory())->create(\TenantCloud\BetterReflection\Relocated\PhpParser\ParserFactory::ONLY_PHP7, $lexer);
        $code = \file_get_contents($file);
        $code = \str_replace("\r\n", "\n", $code);
        $stmts = $parser->parse($code);
        $traverser = new \TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser();
        $traverser->addVisitor(new \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitor\NameResolver(null, ['replaceNodes' => \false]));
        $stmts = $traverser->traverse($stmts);
        return [$code, $stmts];
    }
    private function getAttributes($from) : array
    {
        if (\PHP_VERSION_ID < 80000) {
            return [];
        }
        $res = [];
        foreach ($from->getAttributes() as $attr) {
            $res[] = new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Attribute($attr->getName(), $attr->getArguments());
        }
        return $res;
    }
}
