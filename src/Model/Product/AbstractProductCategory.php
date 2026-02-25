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

    #[\Override]
    public function getImage(): ?string
    {
        return $this->getImageRef()?->getFullPath();
    }

    #[\Override]
    public function setImage(string $image): static
    {
        $imageRef = $this->getImageRef();
        if ($imageRef !== null) {
            $imageRef->setFilename($image);
        }

        return $this;
    }

    #[\Override]
    public function getParentCategory(): ?ProductCategoryInterface
    {
        $parent = $this->getParent();

        return $parent instanceof ProductCategoryInterface ? $parent : null;
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
