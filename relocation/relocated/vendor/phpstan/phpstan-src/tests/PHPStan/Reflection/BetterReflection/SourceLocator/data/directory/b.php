<?php

namespace TenantCloud\BetterReflection\Relocated;

class BFoo
{
    function doBar()
    {
    }
}
function doBar()
{
}
function doBaz()
{
}
function &get_smarty()
{
    global $smarty;
    return $smarty;
}
function &get_smarty2()
{
    global $smarty;
    return $smarty;
}
