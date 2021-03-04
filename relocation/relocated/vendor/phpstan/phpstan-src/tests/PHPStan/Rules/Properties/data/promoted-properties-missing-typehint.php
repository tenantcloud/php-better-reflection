<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\PromotedPropertiesMissingTypehint;

class Foo
{
    /**
     * @param int $baz
     */
    public function __construct(
        private int $foo,
        /** @var int */
        private $bar,
        private $baz,
        private $lorem,
        private array $ipsum
    )
    {
    }
}
