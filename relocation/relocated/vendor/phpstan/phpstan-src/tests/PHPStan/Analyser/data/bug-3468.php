<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3468;

class NewInterval extends \DateInterval
{
}
function (\TenantCloud\BetterReflection\Relocated\Bug3468\NewInterval $ni) : void {
    $ni->f = 0.1;
};
class NewDocument extends \DOMDocument
{
}
function (\TenantCloud\BetterReflection\Relocated\Bug3468\NewDocument $nd) : void {
    $element = $nd->documentElement;
};
