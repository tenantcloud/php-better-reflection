<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class TemplateTypeHelperTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function testIssue2512() : void
    {
        $templateType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('a'), 'T', null, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($templateType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap(['T' => $templateType]));
        $this->assertEquals('T (function a(), parameter)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($templateType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap(['T' => new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateTime::class), $templateType])]));
        $this->assertEquals('DateTime&T (function a(), parameter)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
    }
}
