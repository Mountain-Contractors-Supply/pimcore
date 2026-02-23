<?php

declare(strict_types=1);

namespace App\Provider\User;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\User\CustomerInterface;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Resolver\DefaultDataResolver;
use Pimcore\Model\DataObject\Customer;

/**
 * @implements DataProviderInterface<CustomerInterface>
 */
#[DataProvider(CustomerInterface::class, DefaultDataResolver::class, 10)]
final readonly class PimcoreCustomerProvider implements DataProviderInterface
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
    public function get(string $className, mixed $data = null): ?CustomerInterface
    {
        if (!isset($data['id'])) {
            return null;
        }

        $customer = Customer::getByEmail($data['id'], 1);

        return $customer instanceof CustomerInterface ? $customer : null;
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
