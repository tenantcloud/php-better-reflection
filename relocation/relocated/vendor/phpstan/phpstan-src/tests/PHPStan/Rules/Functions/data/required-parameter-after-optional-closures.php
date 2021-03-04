<?php

namespace TenantCloud\BetterReflection\Relocated\RequiredAfterOptional;

function ($foo = null, $bar) : void {
};
function (int $foo = null, $bar) : void {
};
function (int $foo = 1, $bar) : void {
};
function (bool $foo = \true, $bar) : void {
};
