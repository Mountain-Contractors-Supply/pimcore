<?php

namespace App\OptionProvider;

use Exception;
use Pimcore\Model\DataObject\AbstractObject;
use Pimcore\Model\DataObject\ClassDefinition\Data;
use Pimcore\Model\DataObject\OnlineStore;
use Pimcore\Model\WebsiteSetting;

final readonly class OnlineStoreSelect extends AbstractOptionProvider
{
    private const string ONLINE_STORE_ROOT_NAME = 'onlineStoreRoot';

    /**
     * @param array<string, mixed> $context
     * @param Data $fieldDefinition
     * @return array<string, mixed>[]
     * @throws Exception
     */
    public function getOptions(array $context, Data $fieldDefinition): array
    {
        $options = [];
        $onlineStoreRoot = WebsiteSetting::getByName(self::ONLINE_STORE_ROOT_NAME)?->getData();

        if ($onlineStoreRoot instanceof AbstractObject) {
            foreach ($onlineStoreRoot->getChildren() as $onlineStore) {
                if ($onlineStore instanceof OnlineStore) {
                    $options[] = [
                        'key' => $onlineStore->getName(),
                        'value' => $onlineStore->getId(),
                    ];
                }
            }
        }

        return $options;
    }
}
