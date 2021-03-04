<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\PromotedPropertiesExistingClasses;

class Foo
{
    public function __construct(
        public \stdClass $foo,
        /** @var \stdClass */
        public $bar,
        public \TenantCloud\BetterReflection\Relocated\PromotedPropertiesExistingClasses\SomeTrait $baz,
        /** @var SomeTrait */
        public $lorem,
        public \TenantCloud\BetterReflection\Relocated\PromotedPropertiesExistingClasses\Bar $ipsum,
        /** @var Bar */
        public $dolor
    )
    {
    }
}
trait SomeTrait
{
}
