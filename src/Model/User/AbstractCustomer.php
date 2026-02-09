<?php

declare(strict_types=1);

namespace App\Model\User;

use App\Model\AbstractModel;
use Exception;
use McSupply\EcommerceBundle\Dto\User\CustomerInterface;
use Pimcore\Model\DataObject\ClassDefinition\Data\Password;

abstract class AbstractCustomer extends AbstractModel implements CustomerInterface
{
    /**
     * @inheritDoc
     */
    #[\Override]
    public function getUserIdentifier(): string
    {
        $email = $this->getEmail();

        // Ensure we return a non-empty string as required by the UserInterface contract
        if (!is_string($email) || trim($email) === '') {
            throw new \RuntimeException('User identifier (email) is empty or missing.');
        }

        return $email;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getIsActive(): ?bool
    {
        return $this->getPublished();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setIsActive(?bool $isActive): static
    {
        $this->setPublished((bool)$isActive);

        return $this;
    }



    /**
     * @inheritDoc
     */
    #[\Override]
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    #[\Override]
    public function eraseCredentials(): void
    {
        /** @var Password $field */
        $field = $this->getClass()->getFieldDefinition('password');
        $field->getDataForResource($this->getPassword(), $this);
    }
}
