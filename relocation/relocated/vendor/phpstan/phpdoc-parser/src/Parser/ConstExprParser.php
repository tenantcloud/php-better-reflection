<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser;

use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer;
class ConstExprParser
{
    public function parse(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\TokenIterator $tokens, bool $trimStrings = \false) : \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
    {
        if ($tokens->isCurrentTokenType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_FLOAT)) {
            $value = $tokens->currentTokenValue();
            $tokens->next();
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode($value);
        }
        if ($tokens->isCurrentTokenType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_INTEGER)) {
            $value = $tokens->currentTokenValue();
            $tokens->next();
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode($value);
        }
        if ($tokens->isCurrentTokenType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_SINGLE_QUOTED_STRING)) {
            $value = $tokens->currentTokenValue();
            if ($trimStrings) {
                $value = \trim($tokens->currentTokenValue(), "'");
            }
            $tokens->next();
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode($value);
        } elseif ($tokens->isCurrentTokenType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_DOUBLE_QUOTED_STRING)) {
            $value = $tokens->currentTokenValue();
            if ($trimStrings) {
                $value = \trim($tokens->currentTokenValue(), '"');
            }
            $tokens->next();
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode($value);
        } elseif ($tokens->isCurrentTokenType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER)) {
            $identifier = $tokens->currentTokenValue();
            $tokens->next();
            switch (\strtolower($identifier)) {
                case 'true':
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode();
                case 'false':
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode();
                case 'null':
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode();
                case 'array':
                    $tokens->consumeTokenType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_PARENTHESES);
                    return $this->parseArray($tokens, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PARENTHESES);
            }
            if ($tokens->tryConsumeTokenType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_DOUBLE_COLON)) {
                $classConstantName = '';
                if ($tokens->currentTokenType() === \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER) {
                    $classConstantName .= $tokens->currentTokenValue();
                    $tokens->consumeTokenType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER);
                    if ($tokens->tryConsumeTokenType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_WILDCARD)) {
                        $classConstantName .= '*';
                    }
                } else {
                    $tokens->consumeTokenType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_WILDCARD);
                    $classConstantName .= '*';
                }
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode($identifier, $classConstantName);
            }
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode('', $identifier);
        } elseif ($tokens->tryConsumeTokenType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_SQUARE_BRACKET)) {
            return $this->parseArray($tokens, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_SQUARE_BRACKET);
        }
        throw new \LogicException($tokens->currentTokenValue());
    }
    private function parseArray(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\TokenIterator $tokens, int $endToken) : \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode
    {
        $items = [];
        if (!$tokens->tryConsumeTokenType($endToken)) {
            do {
                $items[] = $this->parseArrayItem($tokens);
            } while ($tokens->tryConsumeTokenType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_COMMA) && !$tokens->isCurrentTokenType($endToken));
            $tokens->consumeTokenType($endToken);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode($items);
    }
    private function parseArrayItem(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Parser\TokenIterator $tokens) : \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode
    {
        $expr = $this->parse($tokens);
        if ($tokens->tryConsumeTokenType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_DOUBLE_ARROW)) {
            $key = $expr;
            $value = $this->parse($tokens);
        } else {
            $key = null;
            $value = $expr;
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode($key, $value);
    }
}
