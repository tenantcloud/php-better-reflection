<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3683;

function (\Generator $g) : void {
    $g->throw(new \Exception());
    $g->throw(1);
};
