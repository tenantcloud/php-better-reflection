<?php

namespace TenantCloud\BetterReflection\Relocated\AccessPropertiesClassExists;

use function class_exists;
class Foo
{
    /** @var Bar|Baz */
    private $union;
    public function doFoo() : void
    {
        echo $this->union->lorem;
        if (\class_exists(\TenantCloud\BetterReflection\Relocated\AccessPropertiesClassExists\Bar::class)) {
            echo $this->union->lorem;
        }
        if (\class_exists(\TenantCloud\BetterReflection\Relocated\AccessPropertiesClassExists\Baz::class)) {
            echo $this->union->lorem;
        }
        if (\class_exists(\TenantCloud\BetterReflection\Relocated\AccessPropertiesClassExists\Bar::class) && \class_exists(\TenantCloud\BetterReflection\Relocated\AccessPropertiesClassExists\Baz::class)) {
            echo $this->union->lorem;
        }
    }
    public function doBar($arg) : void
    {
        if (\class_exists(\TenantCloud\BetterReflection\Relocated\AccessPropertiesClassExists\Bar::class) && \class_exists(\TenantCloud\BetterReflection\Relocated\AccessPropertiesClassExists\Baz::class)) {
            if (\is_int($arg->foo)) {
                echo $this->union->lorem;
            }
        }
    }
}
