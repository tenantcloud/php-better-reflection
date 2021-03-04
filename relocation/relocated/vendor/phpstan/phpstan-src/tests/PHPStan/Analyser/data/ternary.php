<?php

namespace TenantCloud\BetterReflection\Relocated;

/** @var bool|null $boolOrNull */
$boolOrNull = \TenantCloud\BetterReflection\Relocated\doFoo();
$bool = $boolOrNull !== null ? $boolOrNull : \false;
$short = $bool ?: null;
/** @var bool $a */
$a = \TenantCloud\BetterReflection\Relocated\doBar();
/** @var bool $b */
$b = \TenantCloud\BetterReflection\Relocated\doBaz();
$c = $a ?: $b;
/** @var string|null $qux */
$qux = \TenantCloud\BetterReflection\Relocated\doQux();
$isQux = $qux !== null ?: $bool;
die;
