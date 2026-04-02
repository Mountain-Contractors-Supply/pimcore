<?php

declare(strict_types=1);

namespace App\Provider\Payment;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Payment\PaymentMethodInterface;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\PaymentMethod;

/**
 * @implements DataProviderInterface<PaymentMethodInterface>
 * @implements ReadOperationInterface<PaymentMethodInterface>
 */
#[DataProvider(PaymentMethodInterface::class, 10)]
class PimcorePaymentMethodProvider implements DataProviderInterface, ReadOperationInterface
{
    #[\Override]
    public function supports(string $className, array $data = []): bool
    {
        return true;
    }

    #[\Override]
    public function get(string $className, array $data = []): ?PaymentMethodInterface
    {
        if (!isset($data['code'])) {
            return null;
        }

        $paymentMethod = PaymentMethod::getByCode($data['code'], 1);

        return $paymentMethod instanceof PaymentMethodInterface ? $paymentMethod : null;
    }
}
