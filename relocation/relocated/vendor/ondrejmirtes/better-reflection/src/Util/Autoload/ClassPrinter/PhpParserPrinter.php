<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\Autoload\ClassPrinter;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_;
use TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard as CodePrinter;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass;
final class PhpParserPrinter implements \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\Autoload\ClassPrinter\ClassPrinterInterface
{
    public function __invoke(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $classInfo) : string
    {
        $nodes = [];
        if ($classInfo->inNamespace()) {
            $nodes[] = new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name($classInfo->getNamespaceName()));
        }
        $nodes[] = $classInfo->getAst();
        return (new \TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard())->prettyPrint($nodes);
    }
}
