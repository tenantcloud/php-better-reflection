<?php

namespace TenantCloud\BetterReflection\Relocated\ComparisonOperators;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class ComparisonOperators
{
    public function null() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', -1 < null);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', 0 < null);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', 1 < null);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \true < null);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \false < null);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', '1' < null);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', 0 <= null);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', '0' <= null);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', null < -1);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', null < 0);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', null < 1);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', null < \true);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', null < \false);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', null < '1');
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', null <= '0');
    }
    public function bool() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', \true > \false);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', \true >= \false);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \true < \false);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \true <= \false);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \false > \true);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \false >= \true);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', \false < \true);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', \false <= \true);
    }
    public function string() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', 'foo' < 'bar');
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', 'foo' <= 'bar');
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', 'foo' > 'bar');
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', 'foo' >= 'bar');
    }
    public function float() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', 1.9 > 1);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', '1.9' > 1);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', 1.9 > 2.1);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', 1.9 > 1.5);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', 1.9 < 2.1);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', 1.9 < 1.5);
    }
    public function unions(int $a, int $b) : void
    {
        if (($a === 17 || $a === 42) && ($b === 3 || $b === 7)) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $a < $b);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $a > $b);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $a <= $b);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $a >= $b);
        }
        if (($a === 11 || $a === 42) && ($b === 3 || $b === 11)) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $a < $b);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $a > $b);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $a <= $b);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $a >= $b);
        }
    }
    public function ranges(int $a, int $b) : void
    {
        if ($a >= 10 && $a <= 20) {
            if ($b >= 30 && $b <= 40) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $a < $b);
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $a > $b);
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $a <= $b);
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $a >= $b);
            }
        }
        if ($a >= 10 && $a <= 25) {
            if ($b >= 25 && $b <= 40) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $a < $b);
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $a > $b);
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $a <= $b);
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $a >= $b);
            }
        }
    }
}
class ComparisonOperatorsInTypeSpecifier
{
    public function null(?int $i, ?float $f, ?string $s, ?bool $b) : void
    {
        if ($i > null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -1>|int<1, max>', $i);
        }
        if ($i >= null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|null', $i);
        }
        if ($i < null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $i);
        }
        if ($i <= null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('0|null', $i);
        }
        if ($f > null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float', $f);
        }
        if ($f >= null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float|null', $f);
        }
        if ($f < null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $f);
        }
        if ($f <= null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('0.0|null', $f);
        }
        if ($s > null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $s);
        }
        if ($s >= null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string|null', $s);
        }
        if ($s < null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $s);
        }
        if ($s <= null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'\'|null', $s);
        }
        if ($b > null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $b);
        }
        if ($b >= null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool|null', $b);
        }
        if ($b < null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $b);
        }
        if ($b <= null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false|null', $b);
        }
    }
    public function bool(?bool $b) : void
    {
        if ($b > \false) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $b);
        }
        if ($b >= \false) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool|null', $b);
        }
        if ($b < \false) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $b);
        }
        if ($b <= \false) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false|null', $b);
        }
        if ($b > \true) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $b);
        }
        if ($b >= \true) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $b);
        }
        if ($b < \true) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false|null', $b);
        }
        if ($b <= \true) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool|null', $b);
        }
    }
    public function string(?string $s) : void
    {
        if ($s < '') {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $s);
        }
        if ($s <= '') {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string|null', $s);
            // Would be nice to have ''|null
        }
    }
    public function intPositive10(?int $i, ?float $f) : void
    {
        if ($i > 10) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<11, max>', $i);
        }
        if ($i >= 10) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<10, max>', $i);
        }
        if ($i < 10) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 9>|null', $i);
        }
        if ($i <= 10) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 10>|null', $i);
        }
        if ($f > 10) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float', $f);
        }
        if ($f >= 10) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float', $f);
        }
        if ($f < 10) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float|null', $f);
        }
        if ($f <= 10) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float|null', $f);
        }
    }
    public function intNegative10(?int $i, ?float $f) : void
    {
        if ($i > -10) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<-9, max>', $i);
        }
        if ($i >= -10) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<-10, max>', $i);
        }
        if ($i < -10) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -11>|null', $i);
        }
        if ($i <= -10) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -10>|null', $i);
        }
        if ($f > -10) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float', $f);
        }
        if ($f >= -10) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float', $f);
        }
        if ($f < -10) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float|null', $f);
        }
        if ($f <= -10) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float|null', $f);
        }
    }
    public function intZero(?int $i, ?float $f) : void
    {
        if ($i > 0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', $i);
        }
        if ($i >= 0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>|null', $i);
        }
        if ($i < 0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -1>', $i);
        }
        if ($i <= 0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 0>|null', $i);
        }
        if ($f > 0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float', $f);
        }
        if ($f >= 0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float|null', $f);
        }
        if ($f < 0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float', $f);
        }
        if ($f <= 0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float|null', $f);
        }
    }
    public function float10(?int $i) : void
    {
        if ($i > 10.0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<11, max>', $i);
        }
        if ($i >= 10.0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<10, max>', $i);
        }
        if ($i < 10.0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 9>|null', $i);
        }
        if ($i <= 10.0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 10>|null', $i);
        }
        if ($i > 10.1) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<11, max>', $i);
        }
        if ($i >= 10.1) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<11, max>', $i);
        }
        if ($i < 10.1) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 10>|null', $i);
        }
        if ($i <= 10.1) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 10>|null', $i);
        }
    }
    public function floatZero(?int $i) : void
    {
        if ($i > 0.0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', $i);
        }
        if ($i >= 0.0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>|null', $i);
        }
        if ($i < 0.0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -1>', $i);
        }
        if ($i <= 0.0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 0>|null', $i);
        }
    }
    public function ranges(int $a, ?int $b) : void
    {
        if ($a >= 17 && $a <= 42) {
            if ($b < $a) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 41>|null', $b);
            }
            if ($b <= $a) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 42>|null', $b);
            }
            if ($b > $a) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<18, max>', $b);
            }
            if ($b >= $a) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<17, max>', $b);
            }
        }
        if ($a >= -17 && $a <= 42) {
            if ($b < $a) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 41>|null', $b);
            }
            if ($b <= $a) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 42>|null', $b);
            }
            if ($b > $a) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<-16, max>', $b);
            }
            if ($b >= $a) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<-17, max>|null', $b);
            }
        }
    }
}
