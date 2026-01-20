<?php

declare(strict_types=1);

namespace App\OptionProvider;

use Pimcore\Model\DataObject\ClassDefinition\Data;
use Pimcore\Model\DataObject\ClassDefinition\Data\Select;
use Pimcore\Model\DataObject\ClassDefinition\DynamicOptionsProvider\SelectOptionsProviderInterface;

/**
 *
 */
readonly abstract class AbstractOptionProvider implements SelectOptionsProviderInterface
{
    /**
     * @param array<string, mixed> $context
     * @param Data $fieldDefinition
     * @return bool
     */
    public function hasStaticOptions(array $context, Data $fieldDefinition): bool
    {
        return true;
    }

    /**
     * @param array<string, mixed> $context
     * @param Data $fieldDefinition
     * @return string|array<string|array{value: string}>|null
     */
    public function getDefaultValue(array $context, Data $fieldDefinition): string|array|null
    {
        if ($fieldDefinition instanceof Select) {
            return $fieldDefinition->getDefaultValue();
        }

        return null;
    }
}
