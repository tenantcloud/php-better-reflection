<?php

namespace TenantCloud\BetterReflection\Relocated\NodeConnecting;

function foobar() : void
{
    if (\rand(0, 1)) {
        switch ('foo') {
            default:
                'bar';
        }
        echo 'test';
        foreach ([] as $val) {
        }
    }
}
