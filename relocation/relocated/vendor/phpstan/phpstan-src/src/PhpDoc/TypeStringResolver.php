<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\TokenIterator;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\TypeParser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class TypeStringResolver
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer $typeLexer;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\TypeParser $typeParser;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer $typeLexer, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\TypeParser $typeParser, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver)
    {
        $this->typeLexer = $typeLexer;
        $this->typeParser = $typeParser;
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function resolve(string $typeString, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope = null) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $tokens = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\TokenIterator($this->typeLexer->tokenize($typeString));
        $typeNode = $this->typeParser->parse($tokens);
        $tokens->consumeTokenType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END);
        return $this->typeNodeResolver->resolve($typeNode, $nameScope ?? new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope(null, []));
    }
}
