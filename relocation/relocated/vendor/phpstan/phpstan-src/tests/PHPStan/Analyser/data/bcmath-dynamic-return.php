<?php

namespace TenantCloud\BetterReflection\Relocated;

// Verification for constant types: https://3v4l.org/96GSj
/** @var mixed $mixed */
$mixed = \TenantCloud\BetterReflection\Relocated\getMixed();
/** @var int $iUnknown */
$iUnknown = \TenantCloud\BetterReflection\Relocated\getInt();
/** @var string $string */
$string = \TenantCloud\BetterReflection\Relocated\getString();
$iNeg = -5;
$iPos = 5;
$nonNumeric = 'foo';
//  bcdiv ( string $dividend , string $divisor [, int $scale = 0 ] ) : string
// Returns the result of the division as a numeric-string, or NULL if divisor is 0.
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', \bcdiv('10', '0'));
// Warning: Division by zero
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', \bcdiv('10', '0.0'));
// Warning: Division by zero
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', \bcdiv('10', 0.0));
// Warning: Division by zero
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcdiv('10', '1'));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcdiv('10', '-1'));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcdiv('10', '2', 0));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcdiv('10', '2', 1));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcdiv('10', $iNeg));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcdiv('10', $iPos));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcdiv($iPos, $iPos));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('(string&numeric)|null', \bcdiv('10', $mixed));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcdiv('10', $iPos, $iPos));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcdiv('10', $iUnknown));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', \bcdiv('10', $iPos, $nonNumeric));
// Warning: expects parameter 3 to be int, string given in
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', \bcdiv('10', $nonNumeric));
// Warning: bcmath function argument is not well-formed
//  bcmod ( string $dividend , string $divisor [, int $scale = 0 ] ) : string
// Returns the modulus as a numeric-string, or NULL if divisor is 0.
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', \bcmod('10', '0'));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', \bcmod($iPos, '0'));
// Warning: Division by zero
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', \bcmod('10', $nonNumeric));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcmod('10', '1'));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcmod('10', '2', 0));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcmod('5.7', '1.3', 1));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcmod('10', 2.2));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcmod('10', $iUnknown));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcmod('10', '-1'));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcmod($iPos, '-1'));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcmod('10', $iNeg));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcmod('10', $iPos));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcmod('10', -$iNeg));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcmod('10', -$iPos));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('(string&numeric)|null', \bcmod('10', $mixed));
//  bcpowmod ( string $base , string $exponent , string $modulus [, int $scale = 0 ] ) : string
// Returns the result as a numeric-string, or FALSE if modulus is 0 or exponent is negative.
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \bcpowmod('10', '-2', '0'));
// exponent negative, and modulus is 0
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \bcpowmod('10', '-2', '1'));
// exponent negative
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \bcpowmod('10', '2', $nonNumeric));
// Warning: bcmath function argument is not well-formed
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \bcpowmod('10', '-2', '-1'));
// exponent negative
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \bcpowmod('10', '-2', -1.3));
// exponent negative
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \bcpowmod('10', -$iPos, '-1'));
// exponent negative
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \bcpowmod('10', -$iPos, '1'));
// exponent negative
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \bcpowmod('10', $nonNumeric, $nonNumeric));
// Warning: bcmath function argument is not well-formed
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \bcpowmod($iPos, $nonNumeric, $nonNumeric));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \bcpowmod('10', '2', '0'));
// modulus is 0
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \bcpowmod('10', 2.3, '0'));
// modulus is 0
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \bcpowmod('10', '0', '0'));
// modulus is 0
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcpowmod('10', '0', '-2'));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcpowmod('10', '2', '2'));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcpowmod('10', $iUnknown, '2'));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcpowmod($iPos, '2', '2'));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('(string&numeric)|false', \bcpowmod('10', $mixed, $mixed));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcpowmod('10', '2', '2'));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcpowmod('10', -$iNeg, '2'));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcpowmod('10', $nonNumeric, '2'));
// Warning: bcmath function argument is not well-formed
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('(string&numeric)|false', \bcpowmod('10', $iUnknown, $iUnknown));
//  bcsqrt ( string $operand [, int $scale = 0 ] ) : string
// Returns the square root as a numeric-string, or NULL if operand is negative.
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcsqrt('10', $iNeg));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcsqrt('10', 1));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcsqrt('0.00', 1));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcsqrt(0.0, 1));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcsqrt('0', 1));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('(string&numeric)|null', \bcsqrt($iUnknown, $iUnknown));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcsqrt('10', $iPos));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', \bcsqrt('-10', 0));
// Warning: Square root of negative number
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', \bcsqrt($iNeg, 0));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', \bcsqrt('10', $nonNumeric));
// Warning: Second argument must be ?int (Fatal in PHP8)
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcsqrt('10'));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('(string&numeric)|null', \bcsqrt($iUnknown));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', \bcsqrt('-10'));
// Warning: Square root of negative number
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('(string&numeric)|null', \bcsqrt($nonNumeric, -1));
// Warning: bcmath function argument is not well-formed
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('(string&numeric)|null', \bcsqrt('10', $mixed));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', \bcsqrt($iPos));
