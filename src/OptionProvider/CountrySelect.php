<?php

declare(strict_types=1);

namespace App\OptionProvider;

use Exception;
use McSupply\EcommerceBundle\Dto\Address\CountryInterface;
use Pimcore\Model\DataObject\AbstractObject;
use Pimcore\Model\DataObject\ClassDefinition\Data;
use Pimcore\Model\WebsiteSetting;

final readonly class CountrySelect extends AbstractOptionProvider
{
    private const string COUNTRY_ROOT_NAME = 'countryRoot';

    /**
     * @param array<string, mixed> $context
     * @param Data $fieldDefinition
     * @return array<string, mixed>[]
     * @throws Exception
     */
    public function getOptions(array $context, Data $fieldDefinition): array
    {
        $options = [];
        $countryRoot = WebsiteSetting::getByName(self::COUNTRY_ROOT_NAME)?->getData();

        if ($countryRoot instanceof AbstractObject) {
            foreach ($countryRoot->getChildren() as $country) {
                if ($country instanceof CountryInterface) {
                    $options[] = [
                        'key' => $country->getKey(),
                        'value' => $country->getIsoCode(),
                    ];
                }
            }
        }

        return $options;
    }
}
