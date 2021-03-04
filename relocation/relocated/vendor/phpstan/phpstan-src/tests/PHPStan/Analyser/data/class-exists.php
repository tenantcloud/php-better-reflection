<?php

namespace TenantCloud\BetterReflection\Relocated\ClassExistsAutoloadingError;

class Foo
{
    public function doFoo() : void
    {
        $className = 'TenantCloud\\BetterReflection\\Relocated\\PHPStan\\GitHubIssue2359';
        if (\class_exists($className)) {
            \var_dump(new $className());
        }
    }
}
