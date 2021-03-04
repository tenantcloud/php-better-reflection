<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3920;

class HelloWorld
{
    /**
     * @return class-string<Two>
     */
    public function sayHello(string $a)
    {
        $arr = ['a' => \TenantCloud\BetterReflection\Relocated\Bug3920\Two::class, 'c' => \TenantCloud\BetterReflection\Relocated\Bug3920\Two::class];
        return $arr[$a];
    }
    public function sayType() : void
    {
        \call_user_func([\TenantCloud\BetterReflection\Relocated\Bug3920\One::class, 'isType']);
        \call_user_func([\TenantCloud\BetterReflection\Relocated\Bug3920\Two::class, 'isType']);
        $class = $this->sayHello('a');
        $type = $class::isType();
        $callable = [$class, 'isType'];
        \call_user_func($callable);
        if (\is_callable($callable)) {
            \call_user_func($callable);
        }
    }
}
class One
{
    public static function isType() : bool
    {
        return \true;
    }
}
class Two extends \TenantCloud\BetterReflection\Relocated\Bug3920\One
{
}
class Three
{
}
