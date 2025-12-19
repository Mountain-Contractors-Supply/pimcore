<?php

namespace App\Model\User;

use CustomerManagementFrameworkBundle\Model\AbstractCustomer\DefaultAbstractUserawareCustomer;
use McSupply\EcommerceBundle\Dto\Address\AddressInterface;
use McSupply\EcommerceBundle\Dto\Company\AccountInterface;
use McSupply\EcommerceBundle\Dto\User\CustomerInterface;
//use CustomerManagementFrameworkBundle\Model\AbstractCustomer;
use McSupply\EcommerceBundle\Dto\User\PasswordRecoveryInterface;

abstract class AbstractCustomer extends DefaultAbstractUserawareCustomer implements CustomerInterface, PasswordRecoveryInterface
{
    /**
     * @return string|null
     */
    #[\Override]

    public function getGender(): ?string
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    #[\Override]

    public function setGender(?string $gender): static
    {
        return $this;
    }

    /**
     * @return string|null
     */
    #[\Override]

    public function getStreet(): ?string
    {
        return $this->getAddress()?->getLine1();
    }

    /**
     * @inheritDoc
     */
    #[\Override]

    public function setStreet(?string $street): static
    {
        $this->getAddress()?->setLine1($street);

        return $this;
    }

    /**
     * @return string|null
     */
    #[\Override]

    public function getZip(): ?string
    {
        return $this->getAddress()?->getZip();
    }

    /**
     * @inheritDoc
     */
    #[\Override]

    public function setZip(?string $zip): static
    {
        $this->getAddress()?->setZip($zip);

        return $this;
    }

    /**
     * @return string|null
     */
    #[\Override]

    public function getCity(): ?string
    {
        return $this->getAddress()?->getCity();
    }

    /**
     * @inheritDoc
     */
    #[\Override]

    public function setCity(?string $city): static
    {
        $this->getAddress()?->setZip($city);

        return $this;
    }

    /**
     * @return string|null
     */
    #[\Override]

    public function getCountryCode(): ?string
    {
        return $this->getAddress()?->getCountry();
    }

    /**
     * @inheritDoc
     */
    #[\Override]

    public function setCountryCode(?string $countryCode): static
    {
        $this->getAddress()?->setCountry($countryCode);

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[\Override]

    public function setIdEncoded(?string $idEncoded): void
    {

    }

    /**
     * @return string|null
     */
    #[\Override]

    public function getIdEncoded(): ?string
    {
        return null;
    }

    private function getAddress(): ?AddressInterface
    {
        /** @var AccountInterface|null $account */
        $account = $this->getAccounts()[0] ?? null;

        return $account?->getAddress();
    }
}
