<?php

declare(strict_types=1);

namespace App\OptionProvider;

use Pimcore\Model\DataObject\ClassDefinition\Data;
use Pimcore\Model\Site;

final readonly class SiteSelect extends AbstractOptionProvider
{
    /**
     * @param array<string, mixed> $context
     * @param Data $fieldDefinition
     * @return array<string, mixed>[]
     */
    public function getOptions(array $context, Data $fieldDefinition): array
    {
        $options = [];
        $siteListing = (new Site\Listing())->getData();

        if ($siteListing !== null) {
            foreach ($siteListing as $site) {
                $options[] = [
                    'key' => $site->getMainDomain(),
                    'value' => $site->getId(),
                ];
            }
        }

        return $options;
    }
}
