<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4415Rule;

/**
 * @template T
 * @extends \IteratorAggregate<T>
 */
interface CollectionInterface extends \IteratorAggregate
{
    /**
     * @param T $item
     */
    public function has($item) : bool;
    /**
     * @return self<T>
     */
    public function sort() : self;
}
/**
 * @template T
 * @extends CollectionInterface<T>
 */
interface MutableCollectionInterface extends \TenantCloud\BetterReflection\Relocated\Bug4415Rule\CollectionInterface
{
    /**
     * @param T $item
     * @phpstan-return self<T>
     */
    public function add($item) : self;
}
/**
 * @extends CollectionInterface<Category>
 */
interface CategoryCollectionInterface extends \TenantCloud\BetterReflection\Relocated\Bug4415Rule\CollectionInterface
{
    public function has($item) : bool;
    /**
     * @phpstan-return \Iterator<Category>
     */
    public function getIterator() : \Iterator;
}
/**
 * @extends MutableCollectionInterface<Category>
 */
interface MutableCategoryCollectionInterface extends \TenantCloud\BetterReflection\Relocated\Bug4415Rule\CategoryCollectionInterface, \TenantCloud\BetterReflection\Relocated\Bug4415Rule\MutableCollectionInterface
{
}
class CategoryCollection implements \TenantCloud\BetterReflection\Relocated\Bug4415Rule\MutableCategoryCollectionInterface
{
    /** @var array<Category> */
    private $categories = [];
    public function add($item) : \TenantCloud\BetterReflection\Relocated\Bug4415Rule\MutableCollectionInterface
    {
        $this->categories[$item->getName()] = $item;
        return $this;
    }
    public function has($item) : bool
    {
        return isset($this->categories[$item->getName()]);
    }
    public function sort() : \TenantCloud\BetterReflection\Relocated\Bug4415Rule\CollectionInterface
    {
        return $this;
    }
    public function getIterator() : \Iterator
    {
        return new \ArrayIterator($this->categories);
    }
}
class Category
{
    public function getName() : string
    {
        return '';
    }
}
