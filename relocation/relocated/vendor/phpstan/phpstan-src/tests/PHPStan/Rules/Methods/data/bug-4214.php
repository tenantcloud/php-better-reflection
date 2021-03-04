<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4214;

trait AbstractTrait
{
    public abstract function getMessage();
}
class Test extends \Exception
{
    use AbstractTrait;
}
