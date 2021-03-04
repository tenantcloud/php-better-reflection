<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser\Builder;

use TenantCloud\BetterReflection\Relocated\PhpParser;
use TenantCloud\BetterReflection\Relocated\PhpParser\BuilderHelpers;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt;
class Class_ extends \TenantCloud\BetterReflection\Relocated\PhpParser\Builder\Declaration
{
    protected $name;
    protected $extends = null;
    protected $implements = [];
    protected $flags = 0;
    protected $uses = [];
    protected $constants = [];
    protected $properties = [];
    protected $methods = [];
    /**
     * Creates a class builder.
     *
     * @param string $name Name of the class
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    /**
     * Extends a class.
     *
     * @param Name|string $class Name of class to extend
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function extend($class)
    {
        $this->extends = \TenantCloud\BetterReflection\Relocated\PhpParser\BuilderHelpers::normalizeName($class);
        return $this;
    }
    /**
     * Implements one or more interfaces.
     *
     * @param Name|string ...$interfaces Names of interfaces to implement
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function implement(...$interfaces)
    {
        foreach ($interfaces as $interface) {
            $this->implements[] = \TenantCloud\BetterReflection\Relocated\PhpParser\BuilderHelpers::normalizeName($interface);
        }
        return $this;
    }
    /**
     * Makes the class abstract.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeAbstract()
    {
        $this->flags = \TenantCloud\BetterReflection\Relocated\PhpParser\BuilderHelpers::addModifier($this->flags, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_::MODIFIER_ABSTRACT);
        return $this;
    }
    /**
     * Makes the class final.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeFinal()
    {
        $this->flags = \TenantCloud\BetterReflection\Relocated\PhpParser\BuilderHelpers::addModifier($this->flags, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_::MODIFIER_FINAL);
        return $this;
    }
    /**
     * Adds a statement.
     *
     * @param Stmt|PhpParser\Builder $stmt The statement to add
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addStmt($stmt)
    {
        $stmt = \TenantCloud\BetterReflection\Relocated\PhpParser\BuilderHelpers::normalizeNode($stmt);
        $targets = [\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\TraitUse::class => &$this->uses, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassConst::class => &$this->constants, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Property::class => &$this->properties, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod::class => &$this->methods];
        $class = \get_class($stmt);
        if (!isset($targets[$class])) {
            throw new \LogicException(\sprintf('Unexpected node of type "%s"', $stmt->getType()));
        }
        $targets[$class][] = $stmt;
        return $this;
    }
    /**
     * Returns the built class node.
     *
     * @return Stmt\Class_ The built class node
     */
    public function getNode() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node
    {
        return new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_($this->name, ['flags' => $this->flags, 'extends' => $this->extends, 'implements' => $this->implements, 'stmts' => \array_merge($this->uses, $this->constants, $this->properties, $this->methods)], $this->attributes);
    }
}
