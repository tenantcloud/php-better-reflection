<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4351;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Thing
{
    public function doSomething() : void
    {
    }
}
class ParentC
{
    /** @var Thing|null */
    protected $thing;
    protected function __construct()
    {
        $this->thing = null;
    }
}
class HelloWorld extends \TenantCloud\BetterReflection\Relocated\Bug4351\ParentC
{
    public function __construct(\TenantCloud\BetterReflection\Relocated\Bug4351\Thing $thing)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug4351\\Thing|null', $this->thing);
        $this->thing = $thing;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug4351\\Thing', $this->thing);
        parent::__construct();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug4351\\Thing|null', $this->thing);
    }
    public function doFoo(\TenantCloud\BetterReflection\Relocated\Bug4351\Thing $thing)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug4351\\Thing|null', $this->thing);
        $this->thing = $thing;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug4351\\Thing', $this->thing);
        \TenantCloud\BetterReflection\Relocated\Bug4351\UnrelatedClass::doFoo();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug4351\\Thing', $this->thing);
    }
    public function doBar(\TenantCloud\BetterReflection\Relocated\Bug4351\Thing $thing)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug4351\\Thing|null', $this->thing);
        $this->thing = $thing;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug4351\\Thing', $this->thing);
        \TenantCloud\BetterReflection\Relocated\Bug4351\UnrelatedClass::doStaticFoo();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug4351\\Thing', $this->thing);
    }
}
class UnrelatedClass
{
    public function doFoo() : void
    {
    }
    public static function doStaticFoo() : void
    {
    }
}
