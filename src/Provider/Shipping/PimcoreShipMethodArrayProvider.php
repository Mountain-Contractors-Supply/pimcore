<?php

declare(strict_types=1);

namespace App\Provider\Shipping;

use Exception;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Shipping\ShipMethodArray;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\ShipMethod;

/**
 * @implements DataProviderInterface<ShipMethodArray>
 * @implements ReadOperationInterface<ShipMethodArray>
 */
#[DataProvider(ShipMethodArray::class, 10)]
class PimcoreShipMethodArrayProvider implements DataProviderInterface, ReadOperationInterface
{
    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        return true;
    }

    /**
     * @throws Exception
     */
    #[\Override]
    public function get(string $className, mixed $data = null): ShipMethodArray
    {
        $shipMethods = new ShipMethodArray();

        foreach (ShipMethod::getList() as $shipMethod) {
            if (!$shipMethod) {
                continue;
            }

            $shipMethods->add($shipMethod, (string)$shipMethod->getId());
        }

        return $shipMethods;
    }
}
