<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

interface ReflectionWithFilename
{
    /**
     * @return string|false
     */
    public function getFileName();
}
