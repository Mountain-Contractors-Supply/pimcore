<?php

namespace App\OptionProvider;

use App\Consts\Consts;
use Pimcore\Db;
use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\ClassDefinition\Data;
use Pimcore\Model\DataObject\ClassDefinition\DynamicOptionsProvider\SelectOptionsProviderInterface;
use Pimcore\Model\DataObject\Classificationstore\GroupConfig;
use Pimcore\Model\DataObject\Classificationstore\KeyConfig;
use Pimcore\Model\DataObject\Classificationstore\StoreConfig;
use Pimcore\Model\DataObject\ProductCategory;

class HighlightedAttributesProvider implements SelectOptionsProviderInterface
{
    /**
     * Get options dynamically based on the selected AttributeSet classification store group
     *
     * @param array $context Context information from Pimcore
     * @param Data $fieldDefinition Field definition object
     * @return array Array of options in format [["key" => "Display Name", "value" => "value"], ...]
     */
    public function getOptions(array $context, Data $fieldDefinition): array
    {
        $options = [];

        try {
            // Get the current object if it exists
            $object = isset($context['object']) ? $context['object'] : null;
            if (!$object) return $options;

            // Get the AttributeSet (Classification Store Group) value from the current object
            $attributeSet = $this->getAttributeSetValues($object);
            if (!$attributeSet) return $options;

            $storeId = StoreConfig::getByName(Consts::ATTRIBUTE_STORE)?->getId();
            if (!$storeId) return $options;

            $groupsList = new GroupConfig\Listing();
            $groupsList->setCondition('storeId = ? AND name = ?', [$storeId, $attributeSet]);
            $groups = $groupsList->load();

            if (empty($groups)) return $options;

            $group = $groups[0];
            $groupId = $group->getId();

            // Get database connection
            $db = Db::get();

            // Query the relations table to get key IDs for this group
            $keyIds = $db->fetchFirstColumn(
                'SELECT keyId FROM classificationstore_relations WHERE groupId = ?',
                [$groupId]
            );

            // Load the key configs for these IDs
            foreach ($keyIds as $keyId) {
                $keyConfig = KeyConfig::getById($keyId);
                if ($keyConfig && $keyConfig->getEnabled()) {
                    $options[] = [
                        'key' => $keyConfig->getName(),
                        'value' => $keyConfig->getName()
                    ];
                }
            }
        } catch (\Exception $e) {
            // Log error but don't break the interface
            error_log('HighlightedAttributesProvider: Error loading classification store keys: ' . $e->getMessage());
        }

        return $options;
    }

    /**
     * Returns the value which is defined in the 'Default value' field
     */
    public function getDefaultValue(array $context, Data $fieldDefinition): ?string
    {
        if (method_exists($fieldDefinition, 'getDefaultValue')) {
            $defaultValue = $fieldDefinition->getDefaultValue();
            return is_string($defaultValue) ? $defaultValue : null;
        }

        return null;
    }

    /**
     * Indicates whether the options are static or context-dependent
     * Since the options depend on the AttributeSet selection, return false
     * to ensure options are refreshed when the AttributeSet changes
     *
     * @param array $context Context information from Pimcore
     * @param Data $fieldDefinition Field definition object
     * @return bool True if options are static, false if they depend on context/data
     */
    public function hasStaticOptions(array $context, Data $fieldDefinition): bool
    {
        // Return false because options depend on the AttributeSet selection
        // This ensures options are refreshed when AttributeSet changes
        return false;
    }

    private function getAttributeSetValues(DataObject $object): ?string
    {
        $attributeSet = null;

        if ($object instanceof ProductCategory) {
            $attributeSet = $object->getAttributeSet();
        }

        return $attributeSet;
    }
}
