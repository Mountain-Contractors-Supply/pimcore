<?php

declare(strict_types=1);

namespace App\Provider;

use Exception;
use McSupply\EcommerceBundle\Dto\Shipping\ShipMethodInterface;
use McSupply\EcommerceBundle\Provider\OnlineStoreProviderInterface;
use McSupply\EcommerceBundle\Provider\ShipMethodProviderInterface;
use Pimcore\Model\DataObject\ShipMethod;

final readonly class ShipMethodProvider implements ShipMethodProviderInterface
{
    public function __construct(
        private OnlineStoreProviderInterface $onlineStoreProvider,
    )
    {
    }


    /**
     * @inheritDoc
     * @throws Exception
     */
    #[\Override]
    public function getValidShipMethods(): array
    {
        return $this->onlineStoreProvider->filterShipMethods(ShipMethod::getList()->getData());
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getShipMethod(string $shipMethodCode): ?ShipMethodInterface
    {
        return ShipMethod::getByCode($shipMethodCode, 1);
    }
}
