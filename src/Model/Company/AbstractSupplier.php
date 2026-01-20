<?php

declare(strict_types=1);

namespace App\Model\Company;

use App\Model\AbstractModel;
use McSupply\EcommerceBundle\Dto\Company\SupplierInterface;

abstract class AbstractSupplier extends AbstractModel implements SupplierInterface
{
}
