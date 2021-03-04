<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
interface TemplateTypeStrategy
{
    public function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType $left, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $right, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
    public function isArgument() : bool;
}
