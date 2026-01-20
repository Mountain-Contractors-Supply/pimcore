<?php

declare(strict_types=1);

namespace App\OptionProvider;

use Exception;
use Pimcore\Model\DataObject\ClassDefinition\Data;
use Pimcore\Model\Document;
use Pimcore\Model\WebsiteSetting;

final readonly class BusinessCardSelect extends AbstractOptionProvider
{
    private const string BUSINESS_CARD_ROOT_NAME = 'businessCardRoot';

    /**
     * @param array<string, mixed> $context
     * @param Data $fieldDefinition
     * @return array<string, mixed>[]
     * @throws Exception
     */
    public function getOptions(array $context, Data $fieldDefinition): array
    {
        $options = [];
        $businessCardRoot = WebsiteSetting::getByName(self::BUSINESS_CARD_ROOT_NAME)?->getData();

        if ($businessCardRoot instanceof Document) {
            foreach ($businessCardRoot->getChildren() as $businessCard) {
                if ($businessCard instanceof Document) {
                    $options[] = [
                        'key' => $businessCard->getProperty('navigation_name'),
                        'value' => $businessCard->getId(),
                    ];
                }
            }
        }

        return $options;
    }
}
