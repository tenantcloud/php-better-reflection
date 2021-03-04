<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract;
class Attribute extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract
{
    /** @var Name Attribute name */
    public $name;
    /** @var Arg[] Attribute arguments */
    public $args;
    /**
     * @param Node\Name $name       Attribute name
     * @param Arg[]     $args       Attribute arguments
     * @param array     $attributes Additional node attributes
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $name, array $args = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->name = $name;
        $this->args = $args;
    }
    public function getSubNodeNames() : array
    {
        return ['name', 'args'];
    }
    public function getType() : string
    {
        return 'Attribute';
    }
}
