<?php

namespace TenantCloud\BetterReflection\Relocated;

if (!\function_exists('pg_escape_string')) {
    function pg_escape_string() : string
    {
        return '';
    }
}
