<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection;

use TenantCloud\BetterReflection\Relocated\Nette\DI\Config\Adapter;
use TenantCloud\BetterReflection\Relocated\Nette\DI\Config\Helpers;
use TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Reference;
use TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement;
use TenantCloud\BetterReflection\Relocated\Nette\Neon\Entity;
use TenantCloud\BetterReflection\Relocated\Nette\Neon\Neon;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader;
class NeonAdapter implements \TenantCloud\BetterReflection\Relocated\Nette\DI\Config\Adapter
{
    public const CACHE_KEY = 'v11-excludePaths';
    private const PREVENT_MERGING_SUFFIX = '!';
    /** @var FileHelper[] */
    private array $fileHelpers = [];
    /**
     * @param string $file
     * @return mixed[]
     */
    public function load(string $file) : array
    {
        $contents = \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader::read($file);
        try {
            return $this->process((array) \TenantCloud\BetterReflection\Relocated\Nette\Neon\Neon::decode($contents), '', $file);
        } catch (\TenantCloud\BetterReflection\Relocated\Nette\Neon\Exception $e) {
            throw new \TenantCloud\BetterReflection\Relocated\Nette\Neon\Exception(\sprintf('Error while loading %s: %s', $file, $e->getMessage()));
        }
    }
    /**
     * @param mixed[] $arr
     * @return mixed[]
     */
    public function process(array $arr, string $fileKey, string $file) : array
    {
        $res = [];
        foreach ($arr as $key => $val) {
            if (\is_string($key) && \substr($key, -1) === self::PREVENT_MERGING_SUFFIX) {
                if (!\is_array($val) && $val !== null) {
                    throw new \TenantCloud\BetterReflection\Relocated\Nette\DI\InvalidConfigurationException(\sprintf('Replacing operator is available only for arrays, item \'%s\' is not array.', $key));
                }
                $key = \substr($key, 0, -1);
                $val[\TenantCloud\BetterReflection\Relocated\Nette\DI\Config\Helpers::PREVENT_MERGING] = \true;
            }
            if (\is_array($val)) {
                if (!\is_int($key)) {
                    $fileKeyToPass = $fileKey . '[' . $key . ']';
                } else {
                    $fileKeyToPass = $fileKey . '[]';
                }
                $val = $this->process($val, $fileKeyToPass, $file);
            } elseif ($val instanceof \TenantCloud\BetterReflection\Relocated\Nette\Neon\Entity) {
                if (!\is_int($key)) {
                    $fileKeyToPass = $fileKey . '(' . $key . ')';
                } else {
                    $fileKeyToPass = $fileKey . '()';
                }
                if ($val->value === \TenantCloud\BetterReflection\Relocated\Nette\Neon\Neon::CHAIN) {
                    $tmp = null;
                    foreach ($this->process($val->attributes, $fileKeyToPass, $file) as $st) {
                        $tmp = new \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement($tmp === null ? $st->getEntity() : [$tmp, \ltrim(\implode('::', (array) $st->getEntity()), ':')], $st->arguments);
                    }
                    $val = $tmp;
                } else {
                    $tmp = $this->process([$val->value], $fileKeyToPass, $file);
                    $val = new \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement($tmp[0], $this->process($val->attributes, $fileKeyToPass, $file));
                }
            }
            $keyToResolve = $fileKey;
            if (\is_int($key)) {
                $keyToResolve .= '[]';
            } else {
                $keyToResolve .= '[' . $key . ']';
            }
            if (\in_array($keyToResolve, ['[parameters][autoload_files][]', '[parameters][autoload_directories][]', '[parameters][paths][]', '[parameters][excludes_analyse][]', '[parameters][excludePaths][]', '[parameters][excludePaths][analyse][]', '[parameters][excludePaths][analyseAndScan][]', '[parameters][ignoreErrors][][paths][]', '[parameters][ignoreErrors][][path]', '[parameters][bootstrap]', '[parameters][bootstrapFiles][]', '[parameters][scanFiles][]', '[parameters][scanDirectories][]', '[parameters][tmpDir]', '[parameters][memoryLimitFile]', '[parameters][benchmarkFile]', '[parameters][stubFiles][]', '[parameters][symfony][console_application_loader]', '[parameters][symfony][container_xml_path]', '[parameters][doctrine][objectManagerLoader]'], \true) && \is_string($val) && \strpos($val, '%') === \false && \strpos($val, '*') !== 0) {
                $fileHelper = $this->createFileHelperByFile($file);
                $val = $fileHelper->normalizePath($fileHelper->absolutizePath($val));
            }
            $res[$key] = $val;
        }
        return $res;
    }
    /**
     * @param mixed[] $data
     * @return string
     */
    public function dump(array $data) : string
    {
        \array_walk_recursive($data, static function (&$val) : void {
            if (!$val instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement) {
                return;
            }
            $val = self::statementToEntity($val);
        });
        return "# generated by Nette\n\n" . \TenantCloud\BetterReflection\Relocated\Nette\Neon\Neon::encode($data, \TenantCloud\BetterReflection\Relocated\Nette\Neon\Neon::BLOCK);
    }
    private static function statementToEntity(\TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement $val) : \TenantCloud\BetterReflection\Relocated\Nette\Neon\Entity
    {
        \array_walk_recursive($val->arguments, static function (&$val) : void {
            if ($val instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement) {
                $val = self::statementToEntity($val);
            } elseif ($val instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Reference) {
                $val = '@' . $val->getValue();
            }
        });
        $entity = $val->getEntity();
        if ($entity instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Reference) {
            $entity = '@' . $entity->getValue();
        } elseif (\is_array($entity)) {
            if ($entity[0] instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Statement) {
                return new \TenantCloud\BetterReflection\Relocated\Nette\Neon\Entity(\TenantCloud\BetterReflection\Relocated\Nette\Neon\Neon::CHAIN, [self::statementToEntity($entity[0]), new \TenantCloud\BetterReflection\Relocated\Nette\Neon\Entity('::' . $entity[1], $val->arguments)]);
            } elseif ($entity[0] instanceof \TenantCloud\BetterReflection\Relocated\Nette\DI\Definitions\Reference) {
                $entity = '@' . $entity[0]->getValue() . '::' . $entity[1];
            } elseif (\is_string($entity[0])) {
                $entity = $entity[0] . '::' . $entity[1];
            }
        }
        return new \TenantCloud\BetterReflection\Relocated\Nette\Neon\Entity($entity, $val->arguments);
    }
    private function createFileHelperByFile(string $file) : \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper
    {
        $dir = \dirname($file);
        if (!isset($this->fileHelpers[$dir])) {
            $this->fileHelpers[$dir] = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper($dir);
        }
        return $this->fileHelpers[$dir];
    }
}
