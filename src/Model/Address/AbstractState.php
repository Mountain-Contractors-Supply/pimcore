<?php

declare(strict_types=1);

namespace App\Model\Address;

use App\Model\AbstractModel;
use McSupply\EcommerceBundle\Dto\Address\StateInterface;

abstract class AbstractState extends AbstractModel implements StateInterface
{
}
