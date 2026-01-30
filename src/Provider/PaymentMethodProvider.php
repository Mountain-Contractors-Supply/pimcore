<?php

declare(strict_types=1);

namespace App\Provider;

use Exception;
use McSupply\EcommerceBundle\Dto\Payment\PaymentMethodInterface;
use McSupply\EcommerceBundle\Provider\OnlineStoreProviderInterface;
use McSupply\EcommerceBundle\Provider\PaymentMethodProviderInterface;
use Pimcore\Model\DataObject\PaymentMethod;

class PaymentMethodProvider implements PaymentMethodProviderInterface
{
    public function __construct(
        private OnlineStoreProviderInterface $onlineStoreProvider,
    )
    {
    }


    /**
     * @inheritDoc
     * @throws Exception
     */
    #[\Override]
    public function getValidPaymentMethods(): array
    {
        return $this->onlineStoreProvider->filterPaymentMethods(PaymentMethod::getList()->getData());
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getPaymentMethod(string $paymentMethodCode): ?PaymentMethodInterface
    {
        return PaymentMethod::getByCode($paymentMethodCode, 1);
    }
}
