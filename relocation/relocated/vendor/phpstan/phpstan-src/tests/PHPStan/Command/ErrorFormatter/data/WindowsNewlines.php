<?php

namespace TenantCloud\BetterReflection\Relocated\BaselineIntegration;

class WindowsNewlines
{
    /**
     * The following phpdoc is invalid and should trigger a error message containing newlines.
     *
     * @param
     *            $object
     */
    public function phpdocWithNewlines($object)
    {
    }
}
