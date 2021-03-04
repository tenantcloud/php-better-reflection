<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ as NamespaceNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\BetterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompileNodeToValue;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompilerContext;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\InvalidConstantNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\StringCast\ReflectionConstantStringCast;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\CalculateReflectionColum;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\ConstantNodeChecker;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\GetLastDocComment;
use function array_slice;
use function assert;
use function count;
use function explode;
use function implode;
use function substr_count;
class ReflectionConstant implements \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection
{
    /** @var Reflector */
    private $reflector;
    /** @var Node\Stmt\Const_|Node\Expr\FuncCall */
    private $node;
    /** @var LocatedSource */
    private $locatedSource;
    /** @var NamespaceNode|null */
    private $declaringNamespace;
    /** @var int|null */
    private $positionInNode;
    /** @var scalar|array<scalar>|null const value */
    private $value;
    /** @var bool */
    private $valueWasCached = \false;
    private function __construct()
    {
    }
    /**
     * Create a ReflectionConstant by name, using default reflectors etc.
     *
     * @throws IdentifierNotFound
     */
    public static function createFromName(string $constantName) : self
    {
        return (new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\BetterReflection())->constantReflector()->reflect($constantName);
    }
    /**
     * Create a reflection of a constant
     *
     * @internal
     *
     * @param Node\Stmt\Const_|Node\Expr\FuncCall $node Node has to be processed by the PhpParser\NodeVisitor\NameResolver
     */
    public static function createFromNode(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ $namespace = null, ?int $positionInNode = null) : self
    {
        return $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Const_ ? self::createFromConstKeyword($reflector, $node, $locatedSource, $namespace, $positionInNode) : self::createFromDefineFunctionCall($reflector, $node, $locatedSource);
    }
    private static function createFromConstKeyword(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Const_ $node, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ $namespace, int $positionInNode) : self
    {
        $constant = new self();
        $constant->reflector = $reflector;
        $constant->node = $node;
        $constant->locatedSource = $locatedSource;
        $constant->declaringNamespace = $namespace;
        $constant->positionInNode = $positionInNode;
        return $constant;
    }
    /**
     * @throws InvalidConstantNode
     */
    private static function createFromDefineFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource) : self
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\ConstantNodeChecker::assertValidDefineFunctionCall($node);
        $constant = new self();
        $constant->reflector = $reflector;
        $constant->node = $node;
        $constant->locatedSource = $locatedSource;
        return $constant;
    }
    /**
     * Get the "short" name of the constant (e.g. for A\B\FOO, this will return
     * "FOO").
     */
    public function getShortName() : string
    {
        if ($this->node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall) {
            $nameParts = \explode('\\', $this->getNameFromDefineFunctionCall($this->node));
            return $nameParts[\count($nameParts) - 1];
        }
        /** @psalm-suppress PossiblyNullArrayOffset */
        return $this->node->consts[$this->positionInNode]->name->name;
    }
    /**
     * Get the "full" name of the constant (e.g. for A\B\FOO, this will return
     * "A\B\FOO").
     */
    public function getName() : string
    {
        if (!$this->inNamespace()) {
            return $this->getShortName();
        }
        if ($this->node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall) {
            return $this->getNameFromDefineFunctionCall($this->node);
        }
        /**
         * @psalm-suppress UndefinedPropertyFetch
         * @psalm-suppress PossiblyNullArrayOffset
         */
        return $this->node->consts[$this->positionInNode]->namespacedName->toString();
    }
    /**
     * Get the "namespace" name of the constant (e.g. for A\B\FOO, this will
     * return "A\B").
     *
     * @psalm-suppress PossiblyNullPropertyFetch
     */
    public function getNamespaceName() : string
    {
        if (!$this->inNamespace()) {
            return '';
        }
        $namespaceParts = $this->node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall ? \array_slice(\explode('\\', $this->getNameFromDefineFunctionCall($this->node)), 0, -1) : $this->declaringNamespace->name->parts;
        return \implode('\\', $namespaceParts);
    }
    /**
     * Decide if this constant is part of a namespace. Returns false if the constant
     * is in the global namespace or does not have a specified namespace.
     */
    public function inNamespace() : bool
    {
        if ($this->node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall) {
            return \substr_count($this->getNameFromDefineFunctionCall($this->node), '\\') !== 0;
        }
        return $this->declaringNamespace !== null && $this->declaringNamespace->name !== null;
    }
    public function getExtensionName() : ?string
    {
        return $this->locatedSource->getExtensionName();
    }
    /**
     * Is this an internal constant?
     */
    public function isInternal() : bool
    {
        return $this->locatedSource->isInternal();
    }
    /**
     * Is this a user-defined function (will always return the opposite of
     * whatever isInternal returns).
     */
    public function isUserDefined() : bool
    {
        return !$this->isInternal();
    }
    /**
     * @param mixed $value
     */
    public function populateValue($value) : void
    {
        $this->valueWasCached = \true;
        $this->value = $value;
    }
    /**
     * Returns constant value
     *
     * @return scalar|array<scalar>|null
     */
    public function getValue()
    {
        if ($this->valueWasCached !== \false) {
            return $this->value;
        }
        /** @psalm-suppress PossiblyNullArrayOffset */
        $valueNode = $this->node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall ? $this->node->args[1]->value : $this->node->consts[$this->positionInNode]->value;
        $namespace = null;
        if ($this->declaringNamespace !== null && $this->declaringNamespace->name !== null) {
            $namespace = (string) $this->declaringNamespace->name;
        }
        /** @psalm-suppress UndefinedPropertyFetch */
        $this->value = (new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompileNodeToValue())->__invoke($valueNode, new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompilerContext($this->reflector, $this->getFileName(), null, $namespace, null));
        $this->valueWasCached = \true;
        return $this->value;
    }
    public function getFileName() : ?string
    {
        return $this->locatedSource->getFileName();
    }
    public function getLocatedSource() : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource
    {
        return $this->locatedSource;
    }
    /**
     * Get the line number that this constant starts on.
     */
    public function getStartLine() : int
    {
        return $this->node->getStartLine();
    }
    /**
     * Get the line number that this constant ends on.
     */
    public function getEndLine() : int
    {
        return $this->node->getEndLine();
    }
    public function getStartColumn() : int
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\CalculateReflectionColum::getStartColumn($this->locatedSource->getSource(), $this->node);
    }
    public function getEndColumn() : int
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\CalculateReflectionColum::getEndColumn($this->locatedSource->getSource(), $this->node);
    }
    /**
     * Returns the doc comment for this constant
     */
    public function getDocComment() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\GetLastDocComment::forNode($this->node);
    }
    public function __toString() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\StringCast\ReflectionConstantStringCast::toString($this);
    }
    /**
     * @return Node\Stmt\Const_|Node\Expr\FuncCall
     */
    public function getAst() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node
    {
        return $this->node;
    }
    private function getNameFromDefineFunctionCall(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $node) : string
    {
        $nameNode = $node->args[0]->value;
        \assert($nameNode instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_);
        return $nameNode->value;
    }
}
