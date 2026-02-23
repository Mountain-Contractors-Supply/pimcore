<?php

declare(strict_types=1);

namespace App\Provider\Address;

use McSupply\EcommerceBundle\Dto\Address\AddressInterface;
use McSupply\EcommerceBundle\Provider\Address\AddressProviderInterface;
use McSupply\EcommerceBundle\Provider\Company\AccountProviderInterface;

final readonly class AddressProvider implements AddressProviderInterface
{
    public function __construct(
        private AccountProviderInterface $accountProvider,
    )
    {
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getAddresses(): array
    {
        $addresses = [];

        foreach ($this->accountProvider->getValidShipTos() as $shipTo) {
            /** @var AddressInterface $address */
            $address = $shipTo->getAddress();
            $addresses[] = $address;
        }

        return $addresses;
    }
}
