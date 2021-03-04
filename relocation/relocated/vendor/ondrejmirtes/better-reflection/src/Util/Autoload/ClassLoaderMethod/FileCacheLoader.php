<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\Autoload\ClassLoaderMethod;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\Autoload\ClassLoaderMethod\Exception\SignatureCheckFailed;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\Autoload\ClassPrinter\ClassPrinterInterface;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\Autoload\ClassPrinter\PhpParserPrinter;
use TenantCloud\BetterReflection\Relocated\Roave\Signature\CheckerInterface;
use TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\Sha1SumEncoder;
use TenantCloud\BetterReflection\Relocated\Roave\Signature\FileContentChecker;
use TenantCloud\BetterReflection\Relocated\Roave\Signature\FileContentSigner;
use TenantCloud\BetterReflection\Relocated\Roave\Signature\SignerInterface;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function sha1;
use function str_replace;
final class FileCacheLoader implements \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\Autoload\ClassLoaderMethod\LoaderMethodInterface
{
    /** @var string */
    private $cacheDirectory;
    /** @var ClassPrinterInterface */
    private $classPrinter;
    /** @var SignerInterface */
    private $signer;
    /** @var CheckerInterface */
    private $checker;
    public function __construct(string $cacheDirectory, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\Autoload\ClassPrinter\ClassPrinterInterface $classPrinter, \TenantCloud\BetterReflection\Relocated\Roave\Signature\SignerInterface $signer, \TenantCloud\BetterReflection\Relocated\Roave\Signature\CheckerInterface $checker)
    {
        $this->cacheDirectory = $cacheDirectory;
        $this->classPrinter = $classPrinter;
        $this->signer = $signer;
        $this->checker = $checker;
    }
    /**
     * {@inheritdoc}
     *
     * @throws SignatureCheckFailed
     */
    public function __invoke(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $classInfo) : void
    {
        $filename = $this->cacheDirectory . '/' . \sha1($classInfo->getName());
        if (!\file_exists($filename)) {
            $code = "<?php\n" . $this->classPrinter->__invoke($classInfo);
            \file_put_contents($filename, \str_replace('<?php', "<?php\n// " . $this->signer->sign($code), $code));
        }
        if (!$this->checker->check(\file_get_contents($filename))) {
            throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\Autoload\ClassLoaderMethod\Exception\SignatureCheckFailed::fromReflectionClass($classInfo);
        }
        /** @noinspection PhpIncludeInspection */
        require_once $filename;
    }
    public static function defaultFileCacheLoader(string $cacheDirectory) : self
    {
        return new self($cacheDirectory, new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\Autoload\ClassPrinter\PhpParserPrinter(), new \TenantCloud\BetterReflection\Relocated\Roave\Signature\FileContentSigner(new \TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\Sha1SumEncoder()), new \TenantCloud\BetterReflection\Relocated\Roave\Signature\FileContentChecker(new \TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\Sha1SumEncoder()));
    }
}
