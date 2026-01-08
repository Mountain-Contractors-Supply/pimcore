<?php

declare(strict_types=1);

namespace App\Provider;

use McSupply\EcommerceBundle\Dto\User\CustomerInterface;
use McSupply\EcommerceBundle\Provider\CustomerProviderInterface;
use Pimcore\Model\DataObject\Customer;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class CustomerProvider implements CustomerProviderInterface
{
    /**
     * @inheritDoc
     */
    #[\Override]
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function supportsClass(string $class): bool
    {
        return is_subclass_of($class, CustomerInterface::class);
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $customer = Customer::getByEmail($identifier, 1);

        if (!$customer instanceof CustomerInterface || !$customer->getIsActive()) {
            throw new UserNotFoundException(sprintf('User "%s" not found.', $identifier));
        }

        return $customer;
    }
}
