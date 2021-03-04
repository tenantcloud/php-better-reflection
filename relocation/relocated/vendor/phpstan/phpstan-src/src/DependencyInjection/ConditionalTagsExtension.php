<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection;

use TenantCloud\BetterReflection\Relocated\Nette;
use TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolverExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RegistryFactory;
class ConditionalTagsExtension extends \TenantCloud\BetterReflection\Relocated\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \TenantCloud\BetterReflection\Relocated\Nette\Schema\Schema
    {
        $bool = \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::bool();
        return \TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::arrayOf(\TenantCloud\BetterReflection\Relocated\Nette\Schema\Expect::structure([\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory::PROPERTIES_CLASS_REFLECTION_EXTENSION_TAG => $bool, \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory::METHODS_CLASS_REFLECTION_EXTENSION_TAG => $bool, \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory::DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG => $bool, \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory::DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG => $bool, \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory::DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG => $bool, \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory::OPERATOR_TYPE_SPECIFYING_EXTENSION_TAG => $bool, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RegistryFactory::RULE_TAG => $bool, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolverExtension::EXTENSION_TAG => $bool, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierFactory::FUNCTION_TYPE_SPECIFYING_EXTENSION_TAG => $bool, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierFactory::METHOD_TYPE_SPECIFYING_EXTENSION_TAG => $bool, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierFactory::STATIC_METHOD_TYPE_SPECIFYING_EXTENSION_TAG => $bool])->min(1));
    }
    public function beforeCompile() : void
    {
        /** @var mixed[] $config */
        $config = $this->config;
        $builder = $this->getContainerBuilder();
        foreach ($config as $type => $tags) {
            $services = $builder->findByType($type);
            if (\count($services) === 0) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException(\sprintf('No services of type "%s" found.', $type));
            }
            foreach ($services as $service) {
                foreach ($tags as $tag => $parameter) {
                    if ((bool) $parameter) {
                        $service->addTag($tag);
                        continue;
                    }
                }
            }
        }
    }
}
