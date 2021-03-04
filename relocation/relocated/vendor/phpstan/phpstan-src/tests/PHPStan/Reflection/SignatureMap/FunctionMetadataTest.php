<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap;

use TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect;
use TenantCloud\BetterReflection\Relocated\Nette\Schema\Processor;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase;
class FunctionMetadataTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function testSchema() : void
    {
        $data = (require __DIR__ . '/../../../../resources/functionMetadata.php');
        $this->assertIsArray($data);
        $processor = new \TenantCloud\BetterReflection\Relocated\Nette\Schema\Processor();
        $processor->process(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::arrayOf(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::structure(['hasSideEffects' => \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::bool()->required()])->required())->required(), $data);
    }
}
