<?php

declare(strict_types=1);

namespace App\Model\Address;

use McSupply\EcommerceBundle\Dto\Address\GeoLocationInterface;
use McSupply\EcommerceBundle\Dto\Address\GeoLocationTrait;

class AbstractGeoLocation implements GeoLocationInterface
{
    use GeoLocationTrait;
}
