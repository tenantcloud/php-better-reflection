<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser\Builder;

use TenantCloud\BetterReflection\Relocated\PhpParser;
use TenantCloud\BetterReflection\Relocated\PhpParser\BuilderHelpers;
abstract class Declaration implements \TenantCloud\BetterReflection\Relocated\PhpParser\Builder
{
    protected $attributes = [];
    public abstract function addStmt($stmt);
    /**
     * Adds multiple statements.
     *
     * @param array $stmts The statements to add
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addStmts(array $stmts)
    {
        foreach ($stmts as $stmt) {
            $this->addStmt($stmt);
        }
        return $this;
    }
    /**
     * Sets doc comment for the declaration.
     *
     * @param PhpParser\Comment\Doc|string $docComment Doc comment to set
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function setDocComment($docComment)
    {
        $this->attributes['comments'] = [\TenantCloud\BetterReflection\Relocated\PhpParser\BuilderHelpers::normalizeDocComment($docComment)];
        return $this;
    }
}
