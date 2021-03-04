<?php

namespace TenantCloud\BetterReflection\Relocated\RecursionCallable;

/**
 */
class Foo
{
    /**
     * @param Foo|(callable(): mixed) $xxx
     */
    public function abc($xxx) : void
    {
    }
}
