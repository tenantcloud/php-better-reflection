<?php

namespace TenantCloud\BetterReflection\Relocated\Composer\CaBundle;

use TenantCloud\BetterReflection\Relocated\Psr\Log\LoggerInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Process\PhpProcess;
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
class CaBundleTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @return void
     */
    public function testCaPath()
    {
        $caBundle = new \TenantCloud\BetterReflection\Relocated\Composer\CaBundle\CaBundle();
        $this->resetEnv();
        $caPath = $caBundle::getSystemCaRootBundlePath(null);
        $this->assertFileExists($caPath);
    }
    /**
     * @return void
     */
    public function testCaPathNotNull()
    {
        $caBundle = new \TenantCloud\BetterReflection\Relocated\Composer\CaBundle\CaBundle();
        $this->resetEnv();
        $caPathNoNull = $caBundle::getSystemCaRootBundlePath(null);
        $this->assertFileExists($caPathNoNull);
    }
    /**
     * @return void
     */
    public function testCertDir()
    {
        $caBundle = new \TenantCloud\BetterReflection\Relocated\Composer\CaBundle\CaBundle();
        $caBundle::reset();
        $certDir = 'SSL_CERT_DIR=';
        $certPath = __DIR__ . '/../res';
        $this->resetEnv();
        $this->setEnv($certDir . $certPath);
        $sslCertDir = $caBundle::getSystemCaRootBundlePath(null);
        $this->assertFileExists($sslCertDir);
    }
    /**
     * @return void
     */
    public function testCertFile()
    {
        $caBundle = new \TenantCloud\BetterReflection\Relocated\Composer\CaBundle\CaBundle();
        $caBundle::reset();
        $certFile = 'SSL_CERT_FILE=';
        $certFilePath = __DIR__ . '/../res/cacert.pem';
        $this->resetEnv();
        $this->setEnv($certFile . $certFilePath);
        $sslCertFile = $caBundle::getSystemCaRootBundlePath(null);
        $this->assertFileExists($sslCertFile);
    }
    /**
     * @return void
     */
    public function testSslCaFile()
    {
        $sslCaFile = 'openssl.cafile';
        $certFilePath = __DIR__ . '/../res/cacert.pem';
        \ini_set($sslCaFile, $certFilePath);
        $caBundle = new \TenantCloud\BetterReflection\Relocated\Composer\CaBundle\CaBundle();
        $this->resetEnv();
        $openCaFile = $caBundle::getSystemCaRootBundlePath(null);
        $this->assertFileExists($openCaFile);
    }
    /**
     * @return void
     */
    public function testSslCaPath()
    {
        $caBundle = new \TenantCloud\BetterReflection\Relocated\Composer\CaBundle\CaBundle();
        $sslCaPath = 'openssl.capath';
        $certPath = __DIR__ . '/../res';
        $this->resetEnv();
        \ini_set($sslCaPath, $certPath);
        $openCaPath = $caBundle::getSystemCaRootBundlePath(null);
        $this->assertFileExists($openCaPath);
    }
    /**
     * @return void
     */
    public function testValidateCaFile()
    {
        $certFilePath = __DIR__ . '/../res/cacert.pem';
        $caBundle = new \TenantCloud\BetterReflection\Relocated\Composer\CaBundle\CaBundle();
        $validResult = $caBundle::validateCaFile($certFilePath, null);
        $this->assertTrue($validResult);
    }
    /**
     * @return void
     */
    public function testValidateTrustedCaFile()
    {
        $certFilePath = __DIR__ . '/Fixtures/ca-bundle.trust.crt';
        $caBundle = new \TenantCloud\BetterReflection\Relocated\Composer\CaBundle\CaBundle();
        $validResult = $caBundle::validateCaFile($certFilePath, null);
        $this->assertTrue($validResult);
    }
    /**
     * @return void
     */
    public function testOpenBaseDir()
    {
        $oldValue = \ini_get('open_basedir') ?: '';
        \ini_set('open_basedir', \dirname(__DIR__));
        $certFilePath = \TenantCloud\BetterReflection\Relocated\Composer\CaBundle\CaBundle::getSystemCaRootBundlePath();
        $validResult = \TenantCloud\BetterReflection\Relocated\Composer\CaBundle\CaBundle::validateCaFile($certFilePath, null);
        $this->assertTrue($validResult);
        \ini_set('open_basedir', $oldValue);
    }
    /**
     * @param string $envString
     * @return void
     */
    public function setEnv($envString)
    {
        \putenv($envString);
    }
    /**
     * @return void
     */
    public function resetEnv()
    {
        $certDir = 'SSL_CERT_DIR=';
        $certFile = 'SSL_CERT_FILE=';
        $sslCaFile = 'openssl.cafile';
        $sslCaPath = 'openssl.capath';
        $this->setEnv($certDir);
        $this->setEnv($certFile);
    }
}
