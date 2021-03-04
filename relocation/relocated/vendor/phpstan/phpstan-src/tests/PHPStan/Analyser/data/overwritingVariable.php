<?php

namespace TenantCloud\BetterReflection\Relocated\OverwritingVariable;

$var = new \TenantCloud\BetterReflection\Relocated\OverwritingVariable\Bar();
$var = $var->methodFoo();
die;
