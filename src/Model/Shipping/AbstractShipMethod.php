<?php

declare(strict_types=1);

namespace App\Model\Shipping;

use App\Model\AbstractModel;
use McSupply\EcommerceBundle\Dto\Shipping\ShipMethodInterface;

abstract class AbstractShipMethod extends AbstractModel implements ShipMethodInterface
{
}
