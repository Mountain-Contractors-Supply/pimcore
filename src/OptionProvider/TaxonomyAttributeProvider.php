<?php

namespace App\OptionProvider;

use App\Consts\Consts;
use Pimcore\Model\DataObject\ClassDefinition\Data;
use Pimcore\Model\DataObject\ClassDefinition\DynamicOptionsProvider\SelectOptionsProviderInterface;
use Pimcore\Model\DataObject\Classificationstore\GroupConfig;
use Pimcore\Model\DataObject\Classificationstore\StoreConfig;

class TaxonomyAttributeProvider implements SelectOptionsProviderInterface
{
    /**
     * Get options dynamically based on Classification Store groups
     *
     * @param array $context Context information from Pimcore
     * @param Data $fieldDefinition Field definition object
     * @return array Array of options in format [["key" => "Display Name", "value" => "value"], ...]
     */
    public function getOptions(array $context, Data $fieldDefinition): array
    {
        $options = [];

        $storeId = StoreConfig::getByName(Consts::ATTRIBUTE_STORE)?->getId();
        if (!$storeId) return $options;

        try {
            $groupsList = new GroupConfig\Listing();
            $groupsList->setCondition('storeId = ?', [$storeId]);
            $groupsList->setOrderKey('name');
            $groupsList->setOrder('ASC');

            $groups = $groupsList->load();

            foreach ($groups as $group) {
                $options[] = [
                    'key' => $group->getName(),
                    'value' => $group->getName()
                ];
            }
        } catch (\Exception $e) {
            // Log error but don't break the interface
            error_log('TaxonomyAttributeProvider: Error loading classification store groups: ' . $e->getMessage());
        }

        return $options;
    }

    /**
     * Returns the value which is defined in the 'Default value' field
     */
    public function getDefaultValue(array $context, Data $fieldDefinition): ?string
    {
        if (method_exists($fieldDefinition, 'getDefaultValue')) {
            return $fieldDefinition->getDefaultValue();
        }

        return null;
    }

    /**
     * Indicates whether the options are static or context-dependent.
     * Returns true because options are the same for all objects (Classification Store group names)
     * and do not depend on per-object context. This enables batch editing in the grid.
     * Options are still loaded dynamically from the database via getOptions() at layout-load time.
     *
     * @param array $context Context information from Pimcore
     * @param Data $fieldDefinition Field definition object
     * @return bool True if options are static, false if they depend on context/data
     */
    public function hasStaticOptions(array $context, Data $fieldDefinition): bool
    {
        return true;
    }
}
