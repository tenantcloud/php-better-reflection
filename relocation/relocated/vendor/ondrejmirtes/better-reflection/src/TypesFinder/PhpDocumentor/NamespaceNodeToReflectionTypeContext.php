<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\TypesFinder\PhpDocumentor;

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\GroupUse;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\UseUse;
use function array_filter;
use function array_map;
use function array_merge;
use function in_array;
class NamespaceNodeToReflectionTypeContext
{
    public function __invoke(?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ $namespace) : \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context
    {
        if (!$namespace) {
            return new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context('');
        }
        return new \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Types\Context($namespace->name ? $namespace->name->toString() : '', $this->aliasesToFullyQualifiedNames($namespace));
    }
    /**
     * @return string[] indexed by alias
     */
    private function aliasesToFullyQualifiedNames(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        // flatten(flatten(map(stuff)))
        return \array_merge([], ...\array_merge([], ...\array_map(
            /** @param Use_|GroupUse $use */
            static function ($use) : array {
                return \array_map(static function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\UseUse $useUse) use($use) : array {
                    if ($use instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\GroupUse) {
                        return [$useUse->getAlias()->toString() => $use->prefix->toString() . '\\' . $useUse->name->toString()];
                    }
                    return [$useUse->getAlias()->toString() => $useUse->name->toString()];
                }, $use->uses);
            },
            $this->classAlikeUses($namespace)
        )));
    }
    /**
     * @return Use_[]|GroupUse[]
     */
    private function classAlikeUses(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        return \array_filter($namespace->stmts, static function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node) : bool {
            return ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_ || $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\GroupUse) && \in_array($node->type, [\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_::TYPE_UNKNOWN, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Use_::TYPE_NORMAL], \true);
        });
    }
}
