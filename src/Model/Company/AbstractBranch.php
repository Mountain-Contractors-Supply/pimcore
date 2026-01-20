<?php

declare(strict_types=1);

namespace App\Model\Company;

use App\EventListener\PreAddUpdateAwareInterface;
use App\Model\AbstractModel;
use App\Model\Address\AbstractPhoneNumber;
use Locale;
use McSupply\EcommerceBundle\Dto\Address\AddressInterface;
use McSupply\EcommerceBundle\Dto\Address\PhoneNumber;
use McSupply\EcommerceBundle\Dto\Company\BranchInterface;
use McSupply\EcommerceBundle\Dto\Company\SupplierInterface;
use McSupply\EcommerceBundle\Dto\OnlineStore\ValidOnlineStoreAwareTrait;
use McSupply\EcommerceBundle\Dto\Product\ProductTypeAwareTrait;
use Pimcore\Config;
use Pimcore\Model\DataObject\Branch\AddressBrick;
use Pimcore\Model\DataObject\Branch\PhoneNumbersBrick;
use Pimcore\Model\DataObject\Objectbrick;
use Pimcore\Model\DataObject\Objectbrick\Data\Address;

abstract class AbstractBranch extends AbstractModel implements BranchInterface, PreAddUpdateAwareInterface
{
    use ValidOnlineStoreAwareTrait;
    use ProductTypeAwareTrait;

    private ?bool $isValidForCurrentOnlineStore = null;

    public function setValidOnlineStores(array $onlineStores): static
    {
        return $this;
    }

    /**
     * @return AddressBrick
     */
    public abstract function getAddressBrick(): ?Objectbrick;

    /**
     * @return $this
     */
    public abstract function setAddressBrick(?Objectbrick $addressBrick): static;

    /**
     * @return PhoneNumbersBrick
     */
    public abstract function getPhoneNumbersBrick(): ?Objectbrick;

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getCompanyName(): ?string
    {
        $supplier = $this->getParent();
        assert($supplier instanceof SupplierInterface);

        return $supplier->getName();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setCompanyName(?string $companyName): static
    {
        $supplier = $this->getParent();
        assert($supplier instanceof SupplierInterface);
        $supplier->setName($companyName);

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getAddress(): ?AddressInterface
    {
        return $this->getOrCreateAddress();
    }

    /**
     * @inheritDoc
     */
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
    public function getPhoneNumbers(): array
    {
        $phoneNumbers = [];
        $defaultLanguage = Config::getSystemConfiguration()['general']['default_language'] ?? '';

        /** @var AbstractPhoneNumber $phoneNumber */
        foreach ($this->getPhoneNumbersBrick()?->getItems() ?? [] as $phoneNumber) {
            $fieldName = $phoneNumber->getDefinition()->getTitle() ?? 'Phone';

            foreach ($phoneNumber->getLocalizedfields()?->getItems() ?? [] as $locale => $localizedField) {
                if ($localizedField['phoneNumber'] === null) {
                    continue;
                }

                $phoneText = $fieldName;

                if ($locale !== $defaultLanguage) {
                    $phoneText .= ' (' . Locale::getDisplayName($locale) . ')';
                }

                $phoneNumbers[] = (new PhoneNumber())
                    ->setPhoneNumber($localizedField['phoneNumber'])
                    ->setPhoneNumberText($phoneText);
            }
        }

        return $phoneNumbers;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getIsValidForCurrentOnlineStore(): ?bool
    {
        return $this->isValidForCurrentOnlineStore;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setIsValidForCurrentOnlineStore(?bool $branchValidForCurrentOnlineStore): static
    {
        $this->isValidForCurrentOnlineStore = $branchValidForCurrentOnlineStore;

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
        $this->setBranchId($this->getKey());
    }

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
