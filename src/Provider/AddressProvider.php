<?php

declare(strict_types=1);

namespace App\Provider;

use McSupply\EcommerceBundle\Dto\Address\AddressInterface;
use McSupply\EcommerceBundle\Provider\AccountProviderInterface;
use McSupply\EcommerceBundle\Provider\AddressProviderInterface;

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
