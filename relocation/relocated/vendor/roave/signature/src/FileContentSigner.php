<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Roave\Signature;

use TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\EncoderInterface;
final class FileContentSigner implements \TenantCloud\BetterReflection\Relocated\Roave\Signature\SignerInterface
{
    /**
     * @var EncoderInterface
     */
    private $encoder;
    /**
     * {@inheritDoc}
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\Roave\Signature\Encoder\EncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function sign(string $phpCode) : string
    {
        return 'Roave/Signature: ' . $this->encoder->encode($phpCode);
    }
}
