<?php

declare(strict_types=1);

namespace App\Model\Address;

use McSupply\EcommerceBundle\Dto\Address\PhoneNumberInterface;
use Pimcore\Model\DataObject\Localizedfield;
use Pimcore\Model\DataObject\Objectbrick\Data\AbstractData;

abstract class AbstractPhoneNumber extends AbstractData implements PhoneNumberInterface
{
    private ?string $phoneNumberText = null;

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getPhoneNumberText(): ?string
    {
        return $this->phoneNumberText;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setPhoneNumberText(?string $phoneNumberText): static
    {
        $this->phoneNumberText = $phoneNumberText;

        return $this;
    }

    /**
     * @return Localizedfield|null
     */
    public abstract function getLocalizedfields(): ?Localizedfield;
}
