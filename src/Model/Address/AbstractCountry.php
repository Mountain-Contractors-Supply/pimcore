<?php

declare(strict_types=1);

namespace App\Model\Address;

use App\Model\AbstractModel;
use McSupply\EcommerceBundle\Dto\Address\CountryInterface;

abstract class AbstractCountry extends AbstractModel implements CountryInterface
{
}
