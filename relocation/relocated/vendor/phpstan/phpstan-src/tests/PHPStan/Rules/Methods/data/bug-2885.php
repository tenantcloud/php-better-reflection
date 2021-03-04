<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2885;

class Test
{
    /**
     * @return static
     */
    function do()
    {
        return $this->do()->do();
    }
}
