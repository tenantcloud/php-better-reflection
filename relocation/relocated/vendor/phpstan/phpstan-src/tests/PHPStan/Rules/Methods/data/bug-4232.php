<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4232;

function (\ReflectionMethod $m) : bool {
    try {
        $m->getPrototype();
        return \true;
    } catch (\ReflectionException $e) {
        return \false;
    }
};
