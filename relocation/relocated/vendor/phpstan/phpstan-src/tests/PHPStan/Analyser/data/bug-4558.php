<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4558;

use DateTime;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class HelloWorld
{
    /**
     * @var DateTime[]
     */
    private $suggestions = [];
    public function sayHello() : ?\DateTime
    {
        while (\count($this->suggestions) > 0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<DateTime>&nonEmpty', $this->suggestions);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', \count($this->suggestions));
            $try = \array_shift($this->suggestions);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<DateTime>', $this->suggestions);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', \count($this->suggestions));
            if (\rand(0, 1)) {
                return $try;
            }
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<DateTime>', $this->suggestions);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', \count($this->suggestions));
            // we might be out of suggested days, so load some more
            if (\count($this->suggestions) === 0) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array()', $this->suggestions);
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('0', \count($this->suggestions));
                $this->createSuggestions();
            }
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<DateTime>', $this->suggestions);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', \count($this->suggestions));
        }
        return null;
    }
    private function createSuggestions() : void
    {
        $this->suggestions[] = new \DateTime();
    }
}
