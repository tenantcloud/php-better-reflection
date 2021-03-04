<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

if (!\function_exists('imagewebp')) {
    function imagewebp($image, $to = null, int $quality = 80) : bool
    {
    }
}
if (!\class_exists('GdImage')) {
    class GdImage
    {
    }
}
