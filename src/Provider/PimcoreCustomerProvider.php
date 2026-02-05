<?php

namespace App\Provider;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Dto\User\CustomerInterface;
use McSupply\EcommerceBundle\Resolver\DefaultDataResolver;
use Pimcore\Model\DataObject\Customer;

/**
 * @implements DataProviderInterface<CustomerInterface>
 */
#[DataProvider(CustomerInterface::class, DefaultDataResolver::class, 10)]
class PimcoreCustomerProvider implements DataProviderInterface
{
    /**
     * @inheritDoc
     */
    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
       return true;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function get(string $className, mixed $data = null): mixed
    {
        return Customer::getByEmail($data['id'] ?? null, 1);
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function save(mixed $dto, mixed $data = null): void
    {
        // TODO: Implement save() method.
    }
}
