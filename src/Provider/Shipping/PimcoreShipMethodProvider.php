<?php

declare(strict_types=1);

namespace App\Provider\Shipping;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Shipping\ShipMethodInterface;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\ShipMethod;

/**
 * @implements DataProviderInterface<ShipMethodInterface>
 * @implements ReadOperationInterface<ShipMethodInterface>
 */
#[DataProvider(ShipMethodInterface::class, 10)]
final readonly class PimcoreShipMethodProvider implements DataProviderInterface, ReadOperationInterface
{
    #[\Override]
    public function supports(string $className, array $data = []): bool
    {
       return true;
    }

    #[\Override]
    public function get(string $className, array $data = []): ?ShipMethodInterface
    {
        if (!isset($data['code'])) {
            return null;
        }

        $shipMethod = ShipMethod::getByCode($data['code'], 1);

        return $shipMethod instanceof ShipMethodInterface ? $shipMethod : null;
    }
}
