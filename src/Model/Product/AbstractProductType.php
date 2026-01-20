<?php

namespace App\Model\Product;

use App\Model\AbstractModel;
use McSupply\EcommerceBundle\Dto\Product\ProductTypeInterface;
use Pimcore\Model\Asset\Image;

abstract class AbstractProductType extends AbstractModel implements ProductTypeInterface
{
    /**
     * @return Image|null
     */
    public abstract function getImageRef(): ?Image;

    /**
     * @return Image|null
     */
    public abstract function getIconRef(): ?Image;

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getProductTypeId(): ?string
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setProductTypeId(?string $productTypeId): static
    {
        $this->setKey((string)$productTypeId);

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getImage(): ?string
    {
        return $this->getImageRef()?->getThumbnail('productTypeImage')?->getPath();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setImage(?string $image): static
    {
        $this->getImageRef()?->setFilename((string)$image);

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getIcon(): ?string
    {
        return $this->getIconRef()?->getThumbnail('productTypeIcon')?->getPath();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setIcon(?string $icon): static
    {
        $this->getIconRef()?->setFilename((string)$icon);

        return $this;
    }
}
