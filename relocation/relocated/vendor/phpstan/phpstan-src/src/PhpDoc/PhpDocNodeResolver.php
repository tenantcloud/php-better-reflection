<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\DeprecatedTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ExtendsTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ImplementsTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\MethodTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\MethodTagParameter;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\MixinTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ParamTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\PropertyTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ReturnTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\TemplateTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ThrowsTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\UsesTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\VarTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\MixinTagValueNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
class PhpDocNodeResolver
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\ConstExprNodeResolver $constExprNodeResolver;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\ConstExprNodeResolver $constExprNodeResolver)
    {
        $this->typeNodeResolver = $typeNodeResolver;
        $this->constExprNodeResolver = $constExprNodeResolver;
    }
    /**
     * @param PhpDocNode $phpDocNode
     * @param NameScope $nameScope
     * @return array<string|int, \PHPStan\PhpDoc\Tag\VarTag>
     */
    public function resolveVarTags(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : array
    {
        foreach (['@phpstan-var', '@psalm-var', '@var'] as $tagName) {
            $resolved = [];
            foreach ($phpDocNode->getVarTagValues($tagName) as $tagValue) {
                $type = $this->typeNodeResolver->resolve($tagValue->type, $nameScope);
                if ($this->shouldSkipType($tagName, $type)) {
                    continue;
                }
                if ($tagValue->variableName !== '') {
                    $variableName = \substr($tagValue->variableName, 1);
                    $resolved[$variableName] = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\VarTag($type);
                } else {
                    $resolved[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\VarTag($type);
                }
            }
            if (\count($resolved) > 0) {
                return $resolved;
            }
        }
        return [];
    }
    /**
     * @param PhpDocNode $phpDocNode
     * @param NameScope $nameScope
     * @return array<string, \PHPStan\PhpDoc\Tag\PropertyTag>
     */
    public function resolvePropertyTags(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : array
    {
        $resolved = [];
        foreach ($phpDocNode->getPropertyTagValues() as $tagValue) {
            $propertyName = \substr($tagValue->propertyName, 1);
            $propertyType = $this->typeNodeResolver->resolve($tagValue->type, $nameScope);
            $resolved[$propertyName] = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\PropertyTag($propertyType, \true, \true);
        }
        foreach ($phpDocNode->getPropertyReadTagValues() as $tagValue) {
            $propertyName = \substr($tagValue->propertyName, 1);
            $propertyType = $this->typeNodeResolver->resolve($tagValue->type, $nameScope);
            $resolved[$propertyName] = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\PropertyTag($propertyType, \true, \false);
        }
        foreach ($phpDocNode->getPropertyWriteTagValues() as $tagValue) {
            $propertyName = \substr($tagValue->propertyName, 1);
            $propertyType = $this->typeNodeResolver->resolve($tagValue->type, $nameScope);
            $resolved[$propertyName] = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\PropertyTag($propertyType, \false, \true);
        }
        return $resolved;
    }
    /**
     * @param PhpDocNode $phpDocNode
     * @param NameScope $nameScope
     * @return array<string, \PHPStan\PhpDoc\Tag\MethodTag>
     */
    public function resolveMethodTags(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : array
    {
        $resolved = [];
        foreach (['@method', '@psalm-method', '@phpstan-method'] as $tagName) {
            foreach ($phpDocNode->getMethodTagValues($tagName) as $tagValue) {
                $parameters = [];
                foreach ($tagValue->parameters as $parameterNode) {
                    $parameterName = \substr($parameterNode->parameterName, 1);
                    $type = $parameterNode->type !== null ? $this->typeNodeResolver->resolve($parameterNode->type, $nameScope) : new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
                    if ($parameterNode->defaultValue instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode) {
                        $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::addNull($type);
                    }
                    $defaultValue = null;
                    if ($parameterNode->defaultValue !== null) {
                        $defaultValue = $this->constExprNodeResolver->resolve($parameterNode->defaultValue);
                    }
                    $parameters[$parameterName] = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\MethodTagParameter($type, $parameterNode->isReference ? \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createCreatesNewVariable() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), $parameterNode->isVariadic || $parameterNode->defaultValue !== null, $parameterNode->isVariadic, $defaultValue);
                }
                $resolved[$tagValue->methodName] = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\MethodTag($tagValue->returnType !== null ? $this->typeNodeResolver->resolve($tagValue->returnType, $nameScope) : new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $tagValue->isStatic, $parameters);
            }
        }
        return $resolved;
    }
    /**
     * @return array<string, \PHPStan\PhpDoc\Tag\ExtendsTag>
     */
    public function resolveExtendsTags(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : array
    {
        $resolved = [];
        foreach (['@extends', '@template-extends', '@phpstan-extends'] as $tagName) {
            foreach ($phpDocNode->getExtendsTagValues($tagName) as $tagValue) {
                $resolved[$tagValue->type->type->name] = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ExtendsTag($this->typeNodeResolver->resolve($tagValue->type, $nameScope));
            }
        }
        return $resolved;
    }
    /**
     * @return array<string, \PHPStan\PhpDoc\Tag\ImplementsTag>
     */
    public function resolveImplementsTags(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : array
    {
        $resolved = [];
        foreach (['@implements', '@template-implements', '@phpstan-implements'] as $tagName) {
            foreach ($phpDocNode->getImplementsTagValues($tagName) as $tagValue) {
                $resolved[$tagValue->type->type->name] = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ImplementsTag($this->typeNodeResolver->resolve($tagValue->type, $nameScope));
            }
        }
        return $resolved;
    }
    /**
     * @return array<string, \PHPStan\PhpDoc\Tag\UsesTag>
     */
    public function resolveUsesTags(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : array
    {
        $resolved = [];
        foreach (['@use', '@template-use', '@phpstan-use'] as $tagName) {
            foreach ($phpDocNode->getUsesTagValues($tagName) as $tagValue) {
                $resolved[$tagValue->type->type->name] = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\UsesTag($this->typeNodeResolver->resolve($tagValue->type, $nameScope));
            }
        }
        return $resolved;
    }
    /**
     * @param PhpDocNode $phpDocNode
     * @param NameScope $nameScope
     * @return array<string, \PHPStan\PhpDoc\Tag\TemplateTag>
     */
    public function resolveTemplateTags(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : array
    {
        $resolved = [];
        $resolvedPrefix = [];
        $prefixPriority = ['' => 0, 'psalm' => 1, 'phpstan' => 2];
        foreach ($phpDocNode->getTags() as $phpDocTagNode) {
            $valueNode = $phpDocTagNode->value;
            if (!$valueNode instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode) {
                continue;
            }
            $tagName = $phpDocTagNode->name;
            if (\in_array($tagName, ['@template', '@psalm-template', '@phpstan-template'], \true)) {
                $variance = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant();
            } elseif (\in_array($tagName, ['@template-covariant', '@psalm-template-covariant', '@phpstan-template-covariant'], \true)) {
                $variance = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant();
            } else {
                continue;
            }
            if (\strpos($tagName, '@psalm-') === 0) {
                $prefix = 'psalm';
            } elseif (\strpos($tagName, '@phpstan-') === 0) {
                $prefix = 'phpstan';
            } else {
                $prefix = '';
            }
            if (isset($resolved[$valueNode->name])) {
                $setPrefix = $resolvedPrefix[$valueNode->name];
                if ($prefixPriority[$prefix] <= $prefixPriority[$setPrefix]) {
                    continue;
                }
            }
            $resolved[$valueNode->name] = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\TemplateTag($valueNode->name, $valueNode->bound !== null ? $this->typeNodeResolver->resolve($valueNode->bound, $nameScope) : new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $variance);
            $resolvedPrefix[$valueNode->name] = $prefix;
        }
        return $resolved;
    }
    /**
     * @param PhpDocNode $phpDocNode
     * @param NameScope $nameScope
     * @return array<string, \PHPStan\PhpDoc\Tag\ParamTag>
     */
    public function resolveParamTags(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : array
    {
        $resolved = [];
        foreach (['@param', '@psalm-param', '@phpstan-param'] as $tagName) {
            foreach ($phpDocNode->getParamTagValues($tagName) as $tagValue) {
                $parameterName = \substr($tagValue->parameterName, 1);
                $parameterType = $this->typeNodeResolver->resolve($tagValue->type, $nameScope);
                if ($this->shouldSkipType($tagName, $parameterType)) {
                    continue;
                }
                $resolved[$parameterName] = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ParamTag($parameterType, $tagValue->isVariadic);
            }
        }
        return $resolved;
    }
    public function resolveReturnTag(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ReturnTag
    {
        $resolved = null;
        foreach (['@return', '@psalm-return', '@phpstan-return'] as $tagName) {
            foreach ($phpDocNode->getReturnTagValues($tagName) as $tagValue) {
                $type = $this->typeNodeResolver->resolve($tagValue->type, $nameScope);
                if ($this->shouldSkipType($tagName, $type)) {
                    continue;
                }
                $resolved = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ReturnTag($type, \true);
            }
        }
        return $resolved;
    }
    public function resolveThrowsTags(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ThrowsTag
    {
        foreach (['@phpstan-throws', '@throws'] as $tagName) {
            $types = [];
            foreach ($phpDocNode->getThrowsTagValues($tagName) as $tagValue) {
                $type = $this->typeNodeResolver->resolve($tagValue->type, $nameScope);
                if ($this->shouldSkipType($tagName, $type)) {
                    continue;
                }
                $types[] = $type;
            }
            if (\count($types) > 0) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ThrowsTag(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$types));
            }
        }
        return null;
    }
    /**
     * @param PhpDocNode $phpDocNode
     * @param NameScope $nameScope
     * @return array<MixinTag>
     */
    public function resolveMixinTags(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : array
    {
        return \array_map(function (\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\MixinTagValueNode $mixinTagValueNode) use($nameScope) : MixinTag {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\MixinTag($this->typeNodeResolver->resolve($mixinTagValueNode->type, $nameScope));
        }, $phpDocNode->getMixinTagValues());
    }
    public function resolveDeprecatedTag(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\DeprecatedTag
    {
        foreach ($phpDocNode->getDeprecatedTagValues() as $deprecatedTagValue) {
            $description = (string) $deprecatedTagValue;
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\DeprecatedTag($description === '' ? null : $description);
        }
        return null;
    }
    public function resolveIsDeprecated(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode) : bool
    {
        $deprecatedTags = $phpDocNode->getTagsByName('@deprecated');
        return \count($deprecatedTags) > 0;
    }
    public function resolveIsInternal(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode) : bool
    {
        $internalTags = $phpDocNode->getTagsByName('@internal');
        return \count($internalTags) > 0;
    }
    public function resolveIsFinal(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode) : bool
    {
        $finalTags = $phpDocNode->getTagsByName('@final');
        return \count($finalTags) > 0;
    }
    public function resolveIsPure(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode) : bool
    {
        foreach ($phpDocNode->getTags() as $phpDocTagNode) {
            if (\in_array($phpDocTagNode->name, ['@pure', '@psalm-pure', '@phpstan-pure'], \true)) {
                return \true;
            }
        }
        return \false;
    }
    public function resolveIsImpure(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode) : bool
    {
        foreach ($phpDocNode->getTags() as $phpDocTagNode) {
            if (\in_array($phpDocTagNode->name, ['@impure', '@phpstan-impure'], \true)) {
                return \true;
            }
        }
        return \false;
    }
    private function shouldSkipType(string $tagName, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool
    {
        if (\strpos($tagName, '@psalm-') !== 0) {
            return \false;
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
            return \true;
        }
        return $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType && !$type->isExplicit();
    }
}
