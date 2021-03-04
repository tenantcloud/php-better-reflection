<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser\Lexer\TokenEmulator;

use TenantCloud\BetterReflection\Relocated\PhpParser\Lexer\Emulative;
final class FnTokenEmulator extends \TenantCloud\BetterReflection\Relocated\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Lexer\Emulative::PHP_7_4;
    }
    public function getKeywordString() : string
    {
        return 'fn';
    }
    public function getKeywordToken() : int
    {
        return \T_FN;
    }
}
