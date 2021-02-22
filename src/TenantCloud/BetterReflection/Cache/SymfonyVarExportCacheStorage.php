<?php

namespace TenantCloud\BetterReflection\Cache;

use InvalidArgumentException;
use Nette\Utils\Random;
use PHPStan\Cache\CacheItem;
use PHPStan\Cache\CacheStorage;
use PHPStan\Cache\FileCacheStorage;
use PHPStan\File\FileWriter;
use Symfony\Component\VarExporter\VarExporter;

/**
 * Basically a {@see FileCacheStorage}, but uses Symfony's VarExporter as it's faster.
 */
class SymfonyVarExportCacheStorage implements CacheStorage
{
	private string $directory;

	public function __construct(string $directory)
	{
		$this->directory = $directory;
	}

	/**
	 * @return mixed|null
	 */
	public function load(string $key, string $variableKey)
	{
		return (function (string $key, string $variableKey) {
			[,, $filePath] = $this->getFilePaths($key);

			if (!is_file($filePath)) {
				return null;
			}

			$cacheItem = require $filePath;

			if (!$cacheItem instanceof CacheItem) {
				return null;
			}

			if (!$cacheItem->isVariableKeyValid($variableKey)) {
				return null;
			}

			return $cacheItem->getData();
		})($key, $variableKey);
	}

	/**
	 * @param mixed $data
	 */
	public function save(string $key, string $variableKey, $data): void
	{
		[$firstDirectory, $secondDirectory, $path] = $this->getFilePaths($key);
		$this->makeDir($this->directory);
		$this->makeDir($firstDirectory);
		$this->makeDir($secondDirectory);

		$tmpPath = sprintf('%s/%s.tmp', $this->directory, Random::generate());
		$exported = VarExporter::export(new CacheItem($variableKey, $data));

		FileWriter::write(
			$tmpPath,
			sprintf(
				"<?php declare(strict_types = 1);\n\nreturn %s;",
				$exported
			)
		);

		$renameSuccess = @rename($tmpPath, $path);

		if ($renameSuccess) {
			return;
		}

		@unlink($tmpPath);

		if (\DIRECTORY_SEPARATOR === '/' || !file_exists($path)) {
			throw new InvalidArgumentException(sprintf('Could not write data to cache file %s.', $path));
		}
	}

	private function makeDir(string $directory): void
	{
		if (is_dir($directory)) {
			return;
		}

		$result = @mkdir($directory, 0777);

		if ($result === false) {
			clearstatcache();

			if (is_dir($directory)) {
				return;
			}

			$error = error_get_last();

			throw new InvalidArgumentException(sprintf('Failed to create directory "%s" (%s).', $this->directory, $error !== null ? $error['message'] : 'unknown cause'));
		}
	}

	/**
	 * @return array{string, string, string}
	 */
	private function getFilePaths(string $key): array
	{
		$keyHash = sha1($key);
		$firstDirectory = sprintf('%s/%s', $this->directory, mb_substr($keyHash, 0, 2));
		$secondDirectory = sprintf('%s/%s', $firstDirectory, mb_substr($keyHash, 2, 2));
		$filePath = sprintf('%s/%s.php', $secondDirectory, $keyHash);

		return [
			$firstDirectory,
			$secondDirectory,
			$filePath,
		];
	}
}
