<?php

namespace TenantCloud\BetterReflection\Cache;

use ReflectionClass;
use RuntimeException;
use Throwable;

class ReflectionCacheKeyMaster
{
	public function key(ReflectionClass $classReflection): string
	{
		return $classReflection->getName() . '-' . $classReflection->getFileName();
	}

	public function variableKey(ReflectionClass $classReflection): string
	{
		try {
			$variableKey = filemtime($classReflection->getFileName());

			if ($variableKey === false) {
				throw new RuntimeException();
			}
		} catch (Throwable) {
			$variableKey = time();
		}

		return $variableKey;
	}
}
