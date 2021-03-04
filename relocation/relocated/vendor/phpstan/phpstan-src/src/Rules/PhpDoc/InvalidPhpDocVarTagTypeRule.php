<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
use function sprintf;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt>
 */
class InvalidPhpDocVarTagTypeRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck $genericObjectTypeCheck;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck $missingTypehintCheck;
    private bool $checkClassCaseSensitivity;
    private bool $checkMissingVarTagTypehint;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck $genericObjectTypeCheck, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck $missingTypehintCheck, bool $checkClassCaseSensitivity, bool $checkMissingVarTagTypehint)
    {
        $this->fileTypeMapper = $fileTypeMapper;
        $this->reflectionProvider = $reflectionProvider;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->genericObjectTypeCheck = $genericObjectTypeCheck;
        $this->missingTypehintCheck = $missingTypehintCheck;
        $this->checkClassCaseSensitivity = $checkClassCaseSensitivity;
        $this->checkMissingVarTagTypehint = $checkMissingVarTagTypehint;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Property || $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\PropertyProperty) {
            return [];
        }
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        $function = $scope->getFunction();
        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $scope->isInClass() ? $scope->getClassReflection()->getName() : null, $scope->isInTrait() ? $scope->getTraitReflection()->getName() : null, $function !== null ? $function->getName() : null, $docComment->getText());
        $errors = [];
        foreach ($resolvedPhpDoc->getVarTags() as $name => $varTag) {
            $varTagType = $varTag->getType();
            $identifier = 'PHPDoc tag @var';
            if (\is_string($name)) {
                $identifier .= \sprintf(' for variable $%s', $name);
            }
            if ($varTagType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType || $varTagType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType && !$varTagType->isExplicit()) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s contains unresolvable type.', $identifier))->line($docComment->getStartLine())->build();
                continue;
            }
            if ($this->checkMissingVarTagTypehint) {
                foreach ($this->missingTypehintCheck->getIterableTypesWithMissingValueTypehint($varTagType) as $iterableType) {
                    $iterableTypeDescription = $iterableType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly());
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s has no value type specified in iterable type %s.', $identifier, $iterableTypeDescription))->tip(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP)->build();
                }
            }
            $errors = \array_merge($errors, $this->genericObjectTypeCheck->check($varTagType, \sprintf('%s contains generic type %%s but class %%s is not generic.', $identifier), \sprintf('Generic type %%s in %s does not specify all template types of class %%s: %%s', $identifier), \sprintf('Generic type %%s in %s specifies %%d template types, but class %%s supports only %%d: %%s', $identifier), \sprintf('Type %%s in generic type %%s in %s is not subtype of template type %%s of class %%s.', $identifier)));
            foreach ($this->missingTypehintCheck->getNonGenericObjectTypesWithGenericClass($varTagType) as [$innerName, $genericTypeNames]) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s contains generic %s but does not specify its types: %s', $identifier, $innerName, \implode(', ', $genericTypeNames)))->tip(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
            }
            $referencedClasses = $varTagType->getReferencedClasses();
            foreach ($referencedClasses as $referencedClass) {
                if ($this->reflectionProvider->hasClass($referencedClass)) {
                    if ($this->reflectionProvider->getClass($referencedClass)->isTrait()) {
                        $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf(\sprintf('%s has invalid type %%s.', $identifier), $referencedClass))->build();
                    }
                    continue;
                }
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf(\sprintf('%s contains unknown class %%s.', $identifier), $referencedClass))->discoveringSymbolsTip()->build();
            }
            if (!$this->checkClassCaseSensitivity) {
                continue;
            }
            $errors = \array_merge($errors, $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (string $class) use($node) : ClassNameNodePair {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassNameNodePair($class, $node);
            }, $referencedClasses)));
        }
        return $errors;
    }
}
