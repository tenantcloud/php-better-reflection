<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\PhpDocParser;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\TokenIterator;
class PhpDocStringResolver
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer $phpDocLexer;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer $phpDocLexer, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser)
    {
        $this->phpDocLexer = $phpDocLexer;
        $this->phpDocParser = $phpDocParser;
    }
    public function resolve(string $phpDocString) : \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
    {
        $tokens = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\TokenIterator($this->phpDocLexer->tokenize($phpDocString));
        $phpDocNode = $this->phpDocParser->parse($tokens);
        $tokens->consumeTokenType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END);
        return $phpDocNode;
    }
}
