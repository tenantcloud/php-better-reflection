<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\PhpDocParser;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\TokenIterator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node>
 */
class InvalidPhpDocTagValueRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer $phpDocLexer;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer $phpDocLexer, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser)
    {
        $this->phpDocLexer = $phpDocLexer;
        $this->phpDocParser = $phpDocParser;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\FunctionLike && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Foreach_ && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Property && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Assign && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        $phpDocString = $docComment->getText();
        $tokens = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\TokenIterator($this->phpDocLexer->tokenize($phpDocString));
        $phpDocNode = $this->phpDocParser->parse($tokens);
        $errors = [];
        foreach ($phpDocNode->getTags() as $phpDocTag) {
            if (!$phpDocTag->value instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode) {
                continue;
            }
            if (\strpos($phpDocTag->name, '@psalm-') === 0) {
                continue;
            }
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag %s has invalid value (%s): %s', $phpDocTag->name, $phpDocTag->value->value, $phpDocTag->value->exception->getMessage()))->build();
        }
        return $errors;
    }
}
