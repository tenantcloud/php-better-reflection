<?php

declare(strict_types=1);

use Nette\Neon\Neon;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\AssertionFailedError;
use Isolated\Symfony\Component\Finder\Finder;

require_once __DIR__ . '/vendor/autoload.php';

$phpStanSourcesRoot = __DIR__ . '/vendor/phpstan/phpstan-src';
$stubs = [
	$phpStanSourcesRoot . '/resources/functionMap.php',
	$phpStanSourcesRoot . '/resources/functionMap_php74delta.php',
	$phpStanSourcesRoot . '/resources/functionMap_php80delta.php',
	$phpStanSourcesRoot . '/resources/functionMetadata.php',
	__DIR__ . '/vendor/hoa/consistency/Prelude.php',
];
$stubFinder = Finder::create()
	->files()
	->name('*.php')
	->in([
		$phpStanSourcesRoot . '/stubs',
		__DIR__ . '/vendor/jetbrains/phpstorm-stubs',
		__DIR__ . '/vendor/phpstan/php-8-stubs/stubs',
	]);
foreach ($stubFinder as $file) {
	if ($file->getPathName() === __DIR__ . '/vendor/jetbrains/phpstorm-stubs/PhpStormStubsMap.php') {
		continue;
	}

	$stubs[] = $file->getPathName();
}


return [
    'prefix' => 'TenantCloud\\BetterReflection\\Relocated',

	// Relocate this whole dir
	'finders' => [
		Finder::create()
			->files()
			->in('vendor'),
		Finder::create()
			->append([
				'composer.json',
			]),
	],

	'files-whitelist' => $stubs,
	'whitelist' => [
		// it... doesn't play well with php-scoper. Some things result in incorrect class names, some in syntax errors, unfortunately.
		'Hoa\\*'
	],

	'patchers' => array_map(function (Closure $delegate) {
		return function (string $filePath, ...$args) use ($delegate): string {
			// Why the fuck does php-scoper silently hide errors?...
			try {
				return $delegate($filePath, ...$args);
			} catch (Throwable $e) {
				var_dump($filePath, substr((string) $e, 0, 1000));
				die();
			}
		};
	}, [
		function (string $filePath, string $prefix, string $content): string {
			if (!str_ends_with($filePath, 'vendor/nette/di/src/DI/Compiler.php')) {
				return $content;
			}
			return str_replace('|Nette\\\\DI\\\\Statement', sprintf('|\\\\%s\\\\Nette\\\\DI\\\\Statement', addslashes($prefix)), $content);
		},
		function (string $filePath, string $prefix, string $content): string {
			if (!str_ends_with($filePath, 'vendor/nette/di/src/DI/Config/DefinitionSchema.php')) {
				return $content;
			}
			$content = str_replace(
				sprintf('\'%s\\\\callable', addslashes($prefix)),
				'\'callable',
				$content
			);
			$content = str_replace(
				'|Nette\\\\DI\\\\Definitions\\\\Statement',
				sprintf('|%s\\\\Nette\\\\DI\\\\Definitions\\\\Statement', addslashes($prefix)),
				$content
			);

			return $content;
		},
		function (string $filePath, string $prefix, string $content): string {
			if (!str_ends_with($filePath, 'vendor/nette/di/src/DI/Extensions/ExtensionsExtension.php')) {
				return $content;
			}
			$content = str_replace(
				sprintf('\'%s\\\\string', addslashes($prefix)),
				'\'string',
				$content
			);
			$content = str_replace(
				'|Nette\\\\DI\\\\Definitions\\\\Statement',
				sprintf('|%s\\\\Nette\\\\DI\\\\Definitions\\\\Statement', addslashes($prefix)),
				$content
			);

			return $content;
		},
		function (string $filePath, string $prefix, string $content): string {
			if (!str_ends_with($filePath, '.neon')) {
				return $content;
			}

			if ($content === '') {
				return $content;
			}

			$prefixClass = function (string $class) use ($prefix): string {
				if (str_starts_with($class, '%') || str_starts_with($class, 'Hoa\\')) {
					return $class;
				}

				if (str_starts_with($class, '@')) {
					if (!str_contains($class, '\\')) {
						return $class;
					}

					return '@' . $prefix . '\\' . substr($class, 1);
				}

				return $prefix . '\\' . $class;
			};

			$neon = Neon::decode($content);
			$updatedNeon = $neon;

			if (array_key_exists('parameters', $neon) && is_array($neon['parameters']) && array_key_exists('scopeClass', $neon['parameters'])) {
				$updatedNeon['parameters']['scopeClass'] = $prefixClass($neon['parameters']['scopeClass']);
			}

			if (array_key_exists('extensions', $neon)) {
				foreach ($neon['extensions'] as $key => $extension) {
					$updatedNeon['extensions'][$key] = $prefixClass($extension);
				}
			}

			if (array_key_exists('rules', $neon)) {
				foreach ($neon['rules'] as $key => $rule) {
					if (!is_string($rule)) {
						continue;
					}

					$updatedNeon['rules'][$key] = $prefixClass($rule);
				}
			}

			if (array_key_exists('services', $neon)) {
				foreach ($neon['services'] as $key => $service) {
					if (!is_array($service)) {
						continue;
					}

					if (array_key_exists('class', $service) && is_string($service['class'])) {
						$service['class'] = $prefixClass($service['class']);
					}

					if (array_key_exists('factory', $service) && is_string($service['factory'])) {
						$service['factory'] = $prefixClass($service['factory']);
					}

					if (array_key_exists('factory', $service) && $service['factory'] instanceof \Nette\Neon\Entity && is_string($service['factory']->value)) {
						$service['factory']->value = $prefixClass($service['factory']->value);
					}

					if (array_key_exists('implement', $service) && is_string($service['implement'])) {
						$service['implement'] = $prefixClass($service['implement']);
					}

					if (array_key_exists('arguments', $service) && is_array($service['arguments'])) {
						foreach ($service['arguments'] as $i => $argument) {
							if (!is_string($argument)) {
								continue;
							}

							$service['arguments'][$i] = $prefixClass($argument);
						}
					}

					if (array_key_exists('autowired', $service) && is_array($service['autowired'])) {
						foreach ($service['autowired'] as $i => $autowiredName) {
							$service['autowired'][$i] = $prefixClass($autowiredName);
						}
					}

					$updatedNeon['services'][$key] = $service;
				}
			}

			return Neon::encode($updatedNeon, Neon::BLOCK);
		},
		function (string $filePath, string $prefix, string $content): string {
			if (!str_ends_with($filePath, 'vendor/jetbrains/phpstorm-stubs/PhpStormStubsMap.php')) {
				return $content;
			}

			$content = str_replace('\'' . addslashes($prefix) . '\\\\', '\'', $content);

			return $content;
		},
		function (string $filePath, string $prefix, string $content): string {
			if (!str_ends_with($filePath, 'vendor/phpstan/php-8-stubs/Php8StubsMap.php')) {
				return $content;
			}

			$content = str_replace('\'' . addslashes($prefix) . '\\\\', '\'', $content);

			return $content;
		},
		function (string $filePath, string $prefix, string $content): string {
			if (
				!str_ends_with($filePath, 'src/Type/TypehintHelper.php') &&
				!str_ends_with($filePath, 'vendor/ondrejmirtes/better-reflection/src/Reflection/Adapter/ReflectionUnionType.php')
			) {
				return $content;
			}

			return str_replace(sprintf('%s\\ReflectionUnionType', $prefix), 'ReflectionUnionType', $content);
		},
		function (string $filePath, string $prefix, string $content): string {
			if (!str_contains($filePath, 'phpstan/phpstan-src/src/')) {
				return $content;
			}

			return str_replace(sprintf('%s\\Attribute', $prefix), 'Attribute', $content);
		},
		function (string $filePath, string $prefix, string $content): string {
			return str_replace('private static final', 'private static', $content);
		},
		function (string $filePath, string $prefix, string $content): string {
			if (!str_ends_with($filePath, 'vendor/hoa/stream/Stream.php')) {
				return $content;
			}

			$content = str_replace('\Hoa\Consistency::registerShutdownFunction(xcallable(\'Hoa\\\\Stream\\\\Stream::_Hoa_Stream\'));', '', $content);

			return $content;
		},
	]),

	'whitelist-global-functions' => false,
	'whitelist-global-classes' => false,
];

