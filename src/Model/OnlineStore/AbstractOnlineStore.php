<?php

declare(strict_types=1);

namespace App\Model\OnlineStore;

use App\EventListener\PreAddUpdateAwareInterface;
use App\Model\AbstractModel;
use App\Model\Traits\SetKeyFromValueTrait;
use McSupply\EcommerceBundle\Dto\Company\ValidBranchAwareTrait;
use McSupply\EcommerceBundle\Dto\OnlineStore\OnlineStoreInterface;
use McSupply\EcommerceBundle\Dto\Payment\ValidPaymentMethodAwareTrait;
use McSupply\EcommerceBundle\Dto\Product\ProductCategoryInterface;
use McSupply\EcommerceBundle\Dto\Shipping\ValidShipMethodAwareTrait;
use Pimcore\Model\Asset\Image;
use Pimcore\Model\Element\AbstractElement;

abstract class AbstractOnlineStore extends AbstractModel implements OnlineStoreInterface, PreAddUpdateAwareInterface
{
    use SetKeyFromValueTrait;
    use ValidBranchAwareTrait;
    use ValidShipMethodAwareTrait;
    use ValidPaymentMethodAwareTrait;

    /**
     * @return Image|null
     */
    public abstract function getLogoRef(): ?Image;

    /**
     * @param Image|null $image
     * @return $this
     */
    public abstract function setLogoRef(?Image $image): static;

    /**
     * @return AbstractElement|null
     */
    public abstract function getRootCategoryRef(): ?AbstractElement;

    #[\Override]
    public function getRootProductCategory(): ?ProductCategoryInterface
    {
        $categoryRef = $this->getRootCategoryRef();

        return $categoryRef instanceof ProductCategoryInterface ? $categoryRef : null;
    }

    #[\Override]
    public function getLogo(): ?string
    {
        return $this->getLogoRef()?->getFullPath();
    }

    #[\Override]

    public function setLogo(?string $logo): static
    {
        $this->getLogoRef()?->setFilename((string)$logo);

        return $this;
    }

    #[\Override]
    public function onPreAdd(): void
    {
        $this->setName($this->getKey());
        $this->onPreUpdate();
    }

    #[\Override]
    public function onPreUpdate(): void
    {
        $this->setKeyFromValue((string)$this->getName());
    }
}
