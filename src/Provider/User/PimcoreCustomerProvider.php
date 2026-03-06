<?php

declare(strict_types=1);

namespace App\Provider\User;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\User\CustomerInterface;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\Customer;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @implements DataProviderInterface<CustomerInterface>
 * @implements ReadOperationInterface<CustomerInterface>
 * @implements UserProviderInterface<CustomerInterface>
 */
#[DataProvider(CustomerInterface::class, 10)]
final readonly class PimcoreCustomerProvider implements DataProviderInterface, ReadOperationInterface, UserProviderInterface
{
    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
       return true;
    }

    #[\Override]
    public function get(string $className, mixed $data = null): ?CustomerInterface
    {
        if (!isset($data['id'])) {
            return null;
        }

        $customer = Customer::getByEmail($data['id'], 1);

        return $customer instanceof CustomerInterface ? $customer : null;
    }

    #[\Override]
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    #[\Override]
    public function supportsClass(string $class): bool
    {
        return is_a($class, CustomerInterface::class, true);
    }

    #[\Override]
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $customer = $this->get(Customer::class, ['id' => $identifier]);

        if (!$customer instanceof CustomerInterface || !$customer->getIsActive()) {
            throw new UserNotFoundException(sprintf('User "%s" not found.', $identifier));
        }

        return $customer;
    }
}
