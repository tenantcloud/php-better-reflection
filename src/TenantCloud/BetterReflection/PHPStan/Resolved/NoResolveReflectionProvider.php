<?php

namespace TenantCloud\BetterReflection\PHPStan\Resolved;

use ReflectionClass;
use RuntimeException;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassAutoloadingException;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassNotFoundException;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GlobalConstantReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use Throwable;

/**
 * A {@see ReflectionProvider} that is used as a stub for static Broker:: calls inside of {@see Type},
 * so that a real Broker (alongside it's dependencies) is never resolved.
 */
class NoResolveReflectionProvider implements ReflectionProvider
{
	/** @var bool[] */
	private array $hasClassCache = [];

	public function getClassName(string $className): string
	{
		if (!$this->hasClass($className)) {
			throw new ClassNotFoundException($className);
		}

		/* @var class-string $className */
		return (new ReflectionClass($className))->getName();
	}

	public function hasClass(string $className): bool
	{
		$className = trim($className, '\\');

		if (isset($this->hasClassCache[$className])) {
			return $this->hasClassCache[$className];
		}

		spl_autoload_register($autoloader = function (string $autoloadedClassName) use ($className): void {
			$autoloadedClassName = trim($autoloadedClassName, '\\');

			if ($autoloadedClassName !== $className && !$this->isExistsCheckCall()) {
				throw new ClassAutoloadingException($autoloadedClassName);
			}
		});

		try {
			return $this->hasClassCache[$className] = class_exists($className) || interface_exists($className) || trait_exists($className);
		} catch (ClassAutoloadingException $e) {
			throw $e;
		} catch (Throwable $t) {
			throw new ClassAutoloadingException($className, $t);
		} finally {
			spl_autoload_unregister($autoloader);
		}
	}

	public function getClass(string $className): ClassReflection
	{
		throw new RuntimeException('Not implemented');
	}

	public function supportsAnonymousClasses(): bool
	{
		throw new RuntimeException('Not implemented');
	}

	public function getAnonymousClassReflection(Class_ $classNode, Scope $scope): ClassReflection
	{
		throw new RuntimeException('Not implemented');
	}

	public function hasFunction(Name $nameNode, ?Scope $scope): bool
	{
		throw new RuntimeException('Not implemented');
	}

	public function getFunction(Name $nameNode, ?Scope $scope): FunctionReflection
	{
		throw new RuntimeException('Not implemented');
	}

	public function resolveFunctionName(Name $nameNode, ?Scope $scope): ?string
	{
		throw new RuntimeException('Not implemented');
	}

	public function hasConstant(Name $nameNode, ?Scope $scope): bool
	{
		throw new RuntimeException('Not implemented');
	}

	public function getConstant(Name $nameNode, ?Scope $scope): GlobalConstantReflection
	{
		throw new RuntimeException('Not implemented');
	}

	public function resolveConstantName(Name $nameNode, ?Scope $scope): ?string
	{
		throw new RuntimeException('Not implemented');
	}

	private function isExistsCheckCall(): bool
	{
		$debugBacktrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		$existsCallTypes = [
			'class_exists'     => true,
			'interface_exists' => true,
			'trait_exists'     => true,
		];

		foreach ($debugBacktrace as $traceStep) {
			if (
				isset($traceStep['function'], $existsCallTypes[$traceStep['function']]) &&

				// We must ignore the self::hasClass calls
				(!isset($traceStep['file']) || $traceStep['file'] !== __FILE__)
			) {
				return true;
			}
		}

		return false;
	}
}
