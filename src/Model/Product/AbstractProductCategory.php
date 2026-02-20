<?php

declare(strict_types=1);

namespace App\Model\Product;

use App\EventListener\PreAddUpdateAwareInterface;
use App\Model\AbstractModel;
use App\Model\Traits\SetKeyFromValueTrait;
use McSupply\EcommerceBundle\Dto\Product\ProductCategoryInterface;
use Pimcore\Model\Asset\Image;

abstract class AbstractProductCategory extends AbstractModel implements ProductCategoryInterface, PreAddUpdateAwareInterface
{
    use SetKeyFromValueTrait;

    /**
     * @return Image|null
     */
    public abstract function getImageRef(): ?Image;

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getImage(): ?string
    {
        return $this->getImageRef()?->getFullPath();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setImage(?string $image): static
    {
        $this->getImageRef()?->setFilename($image);

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function onPreAdd(): void
    {
        $this->setName($this->getKey());
        $this->onPreUpdate();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function onPreUpdate(): void
    {
        $this->setKeyFromValue((string)$this->getName());
    }
}
