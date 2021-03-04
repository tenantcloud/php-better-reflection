<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast;
class String_ extends \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_String';
    }
}
