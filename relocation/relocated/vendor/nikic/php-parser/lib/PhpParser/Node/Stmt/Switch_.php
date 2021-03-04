<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
class Switch_ extends \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt
{
    /** @var Node\Expr Condition */
    public $cond;
    /** @var Case_[] Case list */
    public $cases;
    /**
     * Constructs a case node.
     *
     * @param Node\Expr $cond       Condition
     * @param Case_[]   $cases      Case list
     * @param array     $attributes Additional attributes
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $cond, array $cases, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->cond = $cond;
        $this->cases = $cases;
    }
    public function getSubNodeNames() : array
    {
        return ['cond', 'cases'];
    }
    public function getType() : string
    {
        return 'Stmt_Switch';
    }
}
