<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection;

use Closure;
use InvalidArgumentException;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\NullableType;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Property as PropertyNode;
use ReflectionException;
use ReflectionProperty as CoreReflectionProperty;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompileNodeToValue;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompilerContext;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\ClassDoesNotExist;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NoObjectProvided;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAnObject;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\ObjectNotInstanceOfClass;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\Uncloneable;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\StringCast\ReflectionPropertyStringCast;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\TypesFinder\FindPropertyType;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\CalculateReflectionColum;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\GetLastDocComment;
use function class_exists;
use function func_num_args;
use function get_class;
use function is_object;
class ReflectionProperty
{
    /** @var ReflectionClass */
    private $declaringClass;
    /** @var ReflectionClass */
    private $implementingClass;
    /** @var PropertyNode */
    private $node;
    /** @var int */
    private $positionInNode;
    /** @var Namespace_|null */
    private $declaringNamespace;
    /** @var bool */
    private $declaredAtCompileTime = \true;
    /** @var bool */
    private $promoted;
    /** @var Reflector */
    private $reflector;
    private function __construct()
    {
    }
    /**
     * Create a reflection of a class's property by its name
     */
    public static function createFromName(string $className, string $propertyName) : self
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass::createFromName($className)->getProperty($propertyName);
    }
    /**
     * Create a reflection of an instance's property by its name
     *
     * @param object $instance
     *
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws IdentifierNotFound
     */
    public static function createFromInstance($instance, string $propertyName) : self
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass::createFromInstance($instance)->getProperty($propertyName);
    }
    public function __toString() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\StringCast\ReflectionPropertyStringCast::toString($this);
    }
    /**
     * @internal
     *
     * @param PropertyNode $node Node has to be processed by the PhpParser\NodeVisitor\NameResolver
     */
    public static function createFromNode(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Property $node, int $positionInNode, ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ $declaringNamespace, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $declaringClass, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $implementingClass, bool $declaredAtCompileTime = \true, bool $promoted = \false) : self
    {
        $prop = new self();
        $prop->reflector = $reflector;
        $prop->node = $node;
        $prop->positionInNode = $positionInNode;
        $prop->declaringNamespace = $declaringNamespace;
        $prop->declaringClass = $declaringClass;
        $prop->implementingClass = $implementingClass;
        $prop->declaredAtCompileTime = $declaredAtCompileTime;
        $prop->promoted = $promoted;
        return $prop;
    }
    /**
     * Set the default visibility of this property. Use the core \ReflectionProperty::IS_* values as parameters, e.g.:
     *
     * @throws InvalidArgumentException
     */
    public function setVisibility(int $newVisibility) : void
    {
        $this->node->flags &= ~\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE & ~\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_::MODIFIER_PROTECTED & ~\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC;
        switch ($newVisibility) {
            case \ReflectionProperty::IS_PRIVATE:
                $this->node->flags |= \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE;
                break;
            case \ReflectionProperty::IS_PROTECTED:
                $this->node->flags |= \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_::MODIFIER_PROTECTED;
                break;
            case \ReflectionProperty::IS_PUBLIC:
                $this->node->flags |= \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC;
                break;
            default:
                throw new \InvalidArgumentException('Visibility should be \\ReflectionProperty::IS_PRIVATE, ::IS_PROTECTED or ::IS_PUBLIC constants');
        }
    }
    /**
     * Has the property been declared at compile-time?
     *
     * Note that unless the property is static, this is hard coded to return
     * true, because we are unable to reflect instances of classes, therefore
     * we can be sure that all properties are always declared at compile-time.
     */
    public function isDefault() : bool
    {
        return $this->declaredAtCompileTime;
    }
    /**
     * Get the core-reflection-compatible modifier values.
     */
    public function getModifiers() : int
    {
        $val = 0;
        $val += $this->isStatic() ? \ReflectionProperty::IS_STATIC : 0;
        $val += $this->isPublic() ? \ReflectionProperty::IS_PUBLIC : 0;
        $val += $this->isProtected() ? \ReflectionProperty::IS_PROTECTED : 0;
        $val += $this->isPrivate() ? \ReflectionProperty::IS_PRIVATE : 0;
        return $val;
    }
    /**
     * Get the name of the property.
     */
    public function getName() : string
    {
        return $this->node->props[$this->positionInNode]->name->name;
    }
    /**
     * Is the property private?
     */
    public function isPrivate() : bool
    {
        return $this->node->isPrivate();
    }
    /**
     * Is the property protected?
     */
    public function isProtected() : bool
    {
        return $this->node->isProtected();
    }
    /**
     * Is the property public?
     */
    public function isPublic() : bool
    {
        return $this->node->isPublic();
    }
    /**
     * Is the property static?
     */
    public function isStatic() : bool
    {
        return $this->node->isStatic();
    }
    public function isPromoted() : bool
    {
        return $this->promoted;
    }
    /**
     * Get the DocBlock type hints as an array of strings.
     *
     * @return string[]
     */
    public function getDocBlockTypeStrings() : array
    {
        $stringTypes = [];
        foreach ($this->getDocBlockTypes() as $type) {
            $stringTypes[] = (string) $type;
        }
        return $stringTypes;
    }
    /**
     * Get the types defined in the DocBlocks. This returns an array because
     * the parameter may have multiple (compound) types specified (for example
     * when you type hint pipe-separated "string|null", in which case this
     * would return an array of Type objects, one for string, one for null.
     *
     * @return Type[]
     */
    public function getDocBlockTypes() : array
    {
        return (new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\TypesFinder\FindPropertyType())->__invoke($this, $this->declaringNamespace);
    }
    public function getDeclaringClass() : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass
    {
        return $this->declaringClass;
    }
    public function getImplementingClass() : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass
    {
        return $this->implementingClass;
    }
    public function getDocComment() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\GetLastDocComment::forNode($this->node);
    }
    /**
     * Get the default value of the property (as defined before constructor is
     * called, when the property is defined)
     *
     * @return scalar|array<scalar>|null
     */
    public function getDefaultValue()
    {
        $defaultValueNode = $this->node->props[$this->positionInNode]->default;
        if ($defaultValueNode === null) {
            return null;
        }
        return (new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompileNodeToValue())->__invoke($defaultValueNode, new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompilerContext($this->reflector, $this->getDeclaringClass()->getFileName(), $this->getDeclaringClass(), $this->getDeclaringClass()->getNamespaceName(), null));
    }
    /**
     * Get the line number that this property starts on.
     */
    public function getStartLine() : int
    {
        return $this->node->getStartLine();
    }
    /**
     * Get the line number that this property ends on.
     */
    public function getEndLine() : int
    {
        return $this->node->getEndLine();
    }
    public function getStartColumn() : int
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\CalculateReflectionColum::getStartColumn($this->declaringClass->getLocatedSource()->getSource(), $this->node);
    }
    public function getEndColumn() : int
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\CalculateReflectionColum::getEndColumn($this->declaringClass->getLocatedSource()->getSource(), $this->node);
    }
    public function getAst() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Property
    {
        return $this->node;
    }
    public function getPositionInAst() : int
    {
        return $this->positionInNode;
    }
    /**
     * {@inheritdoc}
     *
     * @throws Uncloneable
     */
    public function __clone()
    {
        throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\Uncloneable::fromClass(self::class);
    }
    /**
     * @param object|null $object
     *
     * @return mixed
     *
     * @throws ClassDoesNotExist
     * @throws NoObjectProvided
     * @throws NotAnObject
     * @throws ObjectNotInstanceOfClass
     */
    public function getValue($object = null)
    {
        $declaringClassName = $this->getDeclaringClass()->getName();
        if ($this->isStatic()) {
            $this->assertClassExist($declaringClassName);
            return \Closure::bind(function (string $declaringClassName, string $propertyName) {
                return $declaringClassName::${$propertyName};
            }, null, $declaringClassName)->__invoke($declaringClassName, $this->getName());
        }
        $instance = $this->assertObject($object);
        return \Closure::bind(function ($instance, string $propertyName) {
            return $instance->{$propertyName};
        }, $instance, $declaringClassName)->__invoke($instance, $this->getName());
    }
    /**
     * @param object     $object
     * @param mixed|null $value
     *
     * @throws ClassDoesNotExist
     * @throws NoObjectProvided
     * @throws NotAnObject
     * @throws ObjectNotInstanceOfClass
     */
    public function setValue($object, $value = null) : void
    {
        $declaringClassName = $this->getDeclaringClass()->getName();
        if ($this->isStatic()) {
            $this->assertClassExist($declaringClassName);
            \Closure::bind(function (string $declaringClassName, string $propertyName, $value) : void {
                $declaringClassName::${$propertyName} = $value;
            }, null, $declaringClassName)->__invoke($declaringClassName, $this->getName(), \func_num_args() === 2 ? $value : $object);
            return;
        }
        $instance = $this->assertObject($object);
        \Closure::bind(function ($instance, string $propertyName, $value) : void {
            $instance->{$propertyName} = $value;
        }, $instance, $declaringClassName)->__invoke($instance, $this->getName(), $value);
    }
    /**
     * Does this property allow null?
     */
    public function allowsNull() : bool
    {
        if (!$this->hasType()) {
            return \true;
        }
        return $this->node->type instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\NullableType;
    }
    /**
     * Get the ReflectionType instance representing the type declaration for
     * this property
     *
     * (note: this has nothing to do with DocBlocks).
     */
    public function getType() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionType
    {
        $type = $this->node->type;
        if ($type === null) {
            return null;
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionType::createFromTypeAndReflector($type);
    }
    /**
     * Does this property have a type declaration?
     *
     * (note: this has nothing to do with DocBlocks).
     */
    public function hasType() : bool
    {
        return $this->node->type !== null;
    }
    /**
     * Set the property type declaration.
     */
    public function setType(string $newPropertyType) : void
    {
        $this->node->type = new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name($newPropertyType);
    }
    /**
     * Remove the property type declaration completely.
     */
    public function removeType() : void
    {
        $this->node->type = null;
    }
    /**
     * @throws ClassDoesNotExist
     *
     * @psalm-assert class-string $className
     */
    private function assertClassExist(string $className) : void
    {
        if (!\class_exists($className, \false)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\ClassDoesNotExist('Property cannot be retrieved as the class is not loaded');
        }
    }
    /**
     * @param mixed $object
     *
     * @return object
     *
     * @throws NoObjectProvided
     * @throws NotAnObject
     * @throws ObjectNotInstanceOfClass
     *
     * @psalm-assert object $object
     */
    private function assertObject($object)
    {
        if ($object === null) {
            throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NoObjectProvided::create();
        }
        if (!\is_object($object)) {
            throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAnObject::fromNonObject($object);
        }
        $declaringClassName = $this->getDeclaringClass()->getName();
        if (\get_class($object) !== $declaringClassName) {
            throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\ObjectNotInstanceOfClass::fromClassName($declaringClassName);
        }
        return $object;
    }
}
