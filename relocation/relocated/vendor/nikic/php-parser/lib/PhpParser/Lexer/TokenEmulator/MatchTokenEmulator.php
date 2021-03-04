<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser\Lexer\TokenEmulator;

use TenantCloud\BetterReflection\Relocated\PhpParser\Lexer\Emulative;
final class MatchTokenEmulator extends \TenantCloud\BetterReflection\Relocated\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Lexer\Emulative::PHP_8_0;
    }
    public function getKeywordString() : string
    {
        return 'match';
    }
    public function getKeywordToken() : int
    {
        return \T_MATCH;
    }
}
