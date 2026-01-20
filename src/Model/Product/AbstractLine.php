<?php

declare(strict_types=1);

namespace App\Model\Product;

use App\EventListener\PreAddUpdateAwareInterface;
use App\Model\AbstractModel;
use App\Model\Traits\SetKeyFromValueTrait;
use McSupply\EcommerceBundle\Dto\Product\BrandInterface;
use McSupply\EcommerceBundle\Dto\Product\LineInterface;
use Pimcore\Model\DataObject\Brand;
use Pimcore\Model\Element\AbstractElement;

abstract class AbstractLine extends AbstractModel implements LineInterface, PreAddUpdateAwareInterface
{
    use SetKeyFromValueTrait;

    /**
     * @return Brand|null
     */
    public abstract function getBrandRef(): ?AbstractElement;

    /**
     * @param Brand|null $brandRef
     *
     * @return $this
     */
    public abstract function setBrandRef(?AbstractElement $brandRef): static;

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getLineId(): ?string
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setLineId(?string $lineId): static
    {
        $this->setKey((string)$lineId);

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getBrand(): ?BrandInterface
    {
        return $this->getBrandRef();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setBrand(?BrandInterface $brand): static
    {
        /** @var Brand $brand */
        $this->setBrandRef($brand);

        return $this;
    }

    public function onPreAdd(): void
    {
        $this->onPreUpdate();
    }

    public function onPreUpdate(): void
    {
        $this->setKeyFromValue((string)$this->getKey(), '');
        $this->setLineId($this->getKey());
    }
}
