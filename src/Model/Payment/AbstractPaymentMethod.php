<?php

declare(strict_types=1);

namespace App\Model\Payment;

use App\Model\AbstractModel;
use McSupply\EcommerceBundle\Dto\Payment\PaymentMethodInterface;

abstract class AbstractPaymentMethod extends AbstractModel implements PaymentMethodInterface
{
}
