<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

\error_reporting(\E_ALL);
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/PHPStan/Rules/AlwaysFailRule.php';
require_once __DIR__ . '/PHPStan/Rules/DummyRule.php';
require_once __DIR__ . '/phpstan-bootstrap.php';
require_once __DIR__ . '/PHPStan/Analyser/functions.php';
\putenv('PHPSTAN_ALLOW_XDEBUG=1');
eval('trait TraitInEval {

	/**
	 * @param int $i
	 */
	public function doFoo($i)
	{
	}

}');
