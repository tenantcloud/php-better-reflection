<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2740;

/**
 * A collection that can contain members.
 *
 * @extends \IteratorAggregate<int,Member>
 */
interface Collection extends \IteratorAggregate
{
}
/**
 * A member of a collection. Also a collection containing only itself.
 *
 * In the real world, this would contain additional methods.
 */
interface Member extends \TenantCloud\BetterReflection\Relocated\Bug2740\Collection
{
}
class MemberImpl implements \TenantCloud\BetterReflection\Relocated\Bug2740\Member
{
    /**
     * @return \Iterator<int,Member>
     */
    public function getIterator() : \Iterator
    {
        return new \ArrayIterator([$this]);
    }
}
class CollectionImpl implements \TenantCloud\BetterReflection\Relocated\Bug2740\Collection
{
    /**
     * @var array<int,Member>
     */
    private $members;
    public function __construct(\TenantCloud\BetterReflection\Relocated\Bug2740\Member ...$members)
    {
        $this->members = $members;
    }
    /**
     * @return Member
     */
    public function getMember() : \TenantCloud\BetterReflection\Relocated\Bug2740\Member
    {
        return new \TenantCloud\BetterReflection\Relocated\Bug2740\MemberImpl();
    }
    /**
     * @return \Iterator<int,Member>
     */
    public function getIterator() : \Iterator
    {
        return new \ArrayIterator($this->members);
    }
}
