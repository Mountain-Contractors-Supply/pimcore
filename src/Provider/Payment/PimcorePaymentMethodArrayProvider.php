<?php

declare(strict_types=1);

namespace App\Provider\Payment;

use Exception;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Payment\PaymentMethodArray;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\PaymentMethod;

/**
 * @implements DataProviderInterface<PaymentMethodArray>
 * @implements ReadOperationInterface<PaymentMethodArray>
 */
#[DataProvider(PaymentMethodArray::class, 10)]
class PimcorePaymentMethodArrayProvider implements DataProviderInterface, ReadOperationInterface
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
    public function get(string $className, mixed $data = null): PaymentMethodArray
    {
        $paymentMethods = new PaymentMethodArray();

        foreach (PaymentMethod::getList() as $paymentMethod) {
            if (!$paymentMethod) {
                continue;
            }

            $paymentMethods->add($paymentMethod, $paymentMethod->getCode());
        }

        return $paymentMethods;
    }
}
