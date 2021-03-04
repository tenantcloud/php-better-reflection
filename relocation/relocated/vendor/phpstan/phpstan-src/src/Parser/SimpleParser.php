<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Parser;

use TenantCloud\BetterReflection\Relocated\PhpParser\ErrorHandler\Collecting;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitor\NameResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader;
class SimpleParser implements \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Parser $parser;
    private \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitor\NameResolver $nameResolver;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Parser $parser, \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitor\NameResolver $nameResolver)
    {
        $this->parser = $parser;
        $this->nameResolver = $nameResolver;
    }
    /**
     * @param string $file path to a file to parse
     * @return \PhpParser\Node\Stmt[]
     */
    public function parseFile(string $file) : array
    {
        try {
            return $this->parseString(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader::read($file));
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\Parser\ParserErrorsException $e) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\ParserErrorsException($e->getErrors(), $file);
        }
    }
    /**
     * @param string $sourceCode
     * @return \PhpParser\Node\Stmt[]
     */
    public function parseString(string $sourceCode) : array
    {
        $errorHandler = new \TenantCloud\BetterReflection\Relocated\PhpParser\ErrorHandler\Collecting();
        $nodes = $this->parser->parse($sourceCode, $errorHandler);
        if ($errorHandler->hasErrors()) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\ParserErrorsException($errorHandler->getErrors(), null);
        }
        if ($nodes === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $nodeTraverser = new \TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->nameResolver);
        /** @var array<\PhpParser\Node\Stmt> */
        return $nodeTraverser->traverse($nodes);
    }
}
