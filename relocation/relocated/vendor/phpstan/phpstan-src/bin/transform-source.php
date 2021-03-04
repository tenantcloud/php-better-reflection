#!/usr/bin/env php
<?php 
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

require_once __DIR__ . '/../vendor/autoload.php';
\ini_set('memory_limit', '512M');
use TenantCloud\BetterReflection\Relocated\PhpParser\Lexer;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\NullableType;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\UnionType;
use TenantCloud\BetterReflection\Relocated\PhpParser\Parser;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitor;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract;
use TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
class PhpPatcher extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract
{
    public function leaveNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node)
    {
        if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Property) {
            return null;
        }
        if ($node->type === null) {
            return null;
        }
        $docComment = $node->getDocComment();
        if ($docComment !== null) {
            $node->type = null;
            return $node;
        }
        $node->setDocComment(new \TenantCloud\BetterReflection\Relocated\PhpParser\Comment\Doc(\sprintf('/** @var %s */', $this->printType($node->type))));
        $node->type = null;
        return $node;
    }
    /**
     * @param Identifier|Name|NullableType|UnionType $type
     * @return string
     */
    private function printType($type) : string
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\NullableType) {
            return $this->printType($type->type) . '|null';
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\UnionType) {
            throw new \Exception('UnionType not yet supported');
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            $name = $type->toString();
            if ($type->isFullyQualified()) {
                return '\\' . $name;
            }
            return $name;
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
            return $type->name;
        }
        throw new \Exception('Unsupported type class');
    }
}
(function () {
    $dir = __DIR__ . '/../src';
    $lexer = new \TenantCloud\BetterReflection\Relocated\PhpParser\Lexer\Emulative(['usedAttributes' => ['comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos']]);
    $parser = new \TenantCloud\BetterReflection\Relocated\PhpParser\Parser\Php7($lexer, ['useIdentifierNodes' => \true, 'useConsistentVariableNodes' => \true, 'useExpressionStatements' => \true, 'useNopStatements' => \false]);
    $nameResolver = new \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitor\NameResolver(null, ['replaceNodes' => \false]);
    $printer = new \TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard();
    $traverser = new \TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser();
    $traverser->addVisitor(new \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitor\CloningVisitor());
    $traverser->addVisitor($nameResolver);
    $traverser->addVisitor(new \TenantCloud\BetterReflection\Relocated\PhpPatcher($printer));
    $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir), \RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($it as $file) {
        $fileName = $file->getPathname();
        if (!\preg_match('/\\.php$/', $fileName)) {
            continue;
        }
        $code = \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader::read($fileName);
        $origStmts = $parser->parse($code);
        $newCode = $printer->printFormatPreserving($traverser->traverse($origStmts), $origStmts, $lexer->getTokens());
        \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileWriter::write($fileName, $newCode);
    }
})();
