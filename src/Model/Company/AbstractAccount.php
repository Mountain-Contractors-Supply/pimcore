<?php

declare(strict_types=1);

namespace App\Model\Company;

use App\EventListener\PreAddUpdateAwareInterface;
use App\Model\AbstractModel;
use McSupply\EcommerceBundle\Dto\Address\AddressInterface;
use McSupply\EcommerceBundle\Dto\Company\AccountInterface;
use McSupply\EcommerceBundle\Dto\OnlineStore\ValidOnlineStoreAwareTrait;
use Pimcore\Model\DataObject\Branch\AddressBrick;
use Pimcore\Model\DataObject\Objectbrick;
use Pimcore\Model\DataObject\Objectbrick\Data\Address;

abstract class AbstractAccount extends AbstractModel implements AccountInterface, PreAddUpdateAwareInterface
{
    use ValidOnlineStoreAwareTrait;

    /**
     * @return AddressBrick
     */
    public abstract function getAddressBrick(): ?Objectbrick;

    /**
     * @return $this
     */
    public abstract function setAddressBrick(?Objectbrick $addressBrick): static;

    #[\Override]
    public function getAddress(): AddressInterface
    {
        return $this->getOrCreateAddress();
    }

    #[\Override]
    public function setAddress(?AddressInterface $address): static
    {
        /** @var Address $address */
        $this->getAddressBrick()?->setAddress($address);

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function onPreAdd(): void
    {
        $this->onPreUpdate();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function onPreUpdate(): void
    {
        $this->setKey(strtoupper((string)$this->getKey()));
        $this->setAccountId($this->getKey());
    }

    /**
     * @return AddressInterface
     */
    private function getOrCreateAddress(): AddressInterface
    {
        $address = $this->getAddressBrick()?->getAddress();

        if ($address === null) {
            $address = new Address($this);
            $this->setAddress($address);
        }

        return $address;
    }
}
