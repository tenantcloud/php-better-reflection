<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator;

use TenantCloud\BetterReflection\Relocated\Nette;
/**
 * Closure.
 *
 * @property string $body
 */
final class Closure
{
    use Nette\SmartObject;
    use Traits\FunctionLike;
    use Traits\AttributeAware;
    /** @var Parameter[] */
    private $uses = [];
    public static function from(\Closure $closure) : self
    {
        return (new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Factory())->fromFunctionReflection(new \ReflectionFunction($closure));
    }
    public function __toString() : string
    {
        try {
            return (new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Printer())->printClosure($this);
        } catch (\Throwable $e) {
            if (\PHP_VERSION_ID >= 70400) {
                throw $e;
            }
            \trigger_error('Exception in ' . __METHOD__ . "(): {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}", \E_USER_ERROR);
            return '';
        }
    }
    /**
     * @param  Parameter[]  $uses
     * @return static
     */
    public function setUses(array $uses) : self
    {
        (function (\TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Parameter ...$uses) {
        })(...$uses);
        $this->uses = $uses;
        return $this;
    }
    public function getUses() : array
    {
        return $this->uses;
    }
    public function addUse(string $name) : \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Parameter
    {
        return $this->uses[] = new \TenantCloud\BetterReflection\Relocated\Nette\PhpGenerator\Parameter($name);
    }
}
