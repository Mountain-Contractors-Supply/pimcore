<?php

declare(strict_types=1);

namespace App\OptionProvider;

use Exception;
use McSupply\EcommerceBundle\Dto\Address\AddressAwareInterface;
use McSupply\EcommerceBundle\Dto\Address\AddressInterface;
use McSupply\EcommerceBundle\Dto\Address\CountryInterface;
use McSupply\EcommerceBundle\Dto\Address\StateInterface;
use Pimcore\Model\DataObject\ClassDefinition\Data;
use Pimcore\Model\DataObject\ClassDefinition\DefaultValueGeneratorInterface;
use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\DataObject\Country;

final readonly class StateSelect extends AbstractOptionProvider
{
    /**
     * @param array<string, mixed> $context
     * @param Data $fieldDefinition
     * @return array<string, mixed>[]
     * @throws Exception
     */
    public function getOptions(array $context, Data $fieldDefinition): array
    {
        $options = [];
        $object = $context['object'];

        if ($object instanceof AddressAwareInterface &&
           ($address = $object->getAddress()) instanceof AddressInterface &&
           ($country = Country::getByIsoCode(
               $address->getCountry() ?? 'US', 1)
           ) instanceof Country) {

            foreach ($country->getChildren() as $state) {
                if ($state instanceof StateInterface) {
                    $options[] = [
                        'key' => $state->getKey(),
                        'value' => $state->getIsoCode(),
                    ];
                }
            }
        }

        return $options;
    }
}
