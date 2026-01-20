<?php

declare(strict_types=1);

namespace App\Model\Product;

use App\EventListener\PreAddUpdateAwareInterface;
use App\Model\AbstractModel;
use App\Model\Traits\SetKeyFromValueTrait;
use McSupply\EcommerceBundle\Dto\Product\BrandInterface;

abstract class AbstractBrand extends AbstractModel implements BrandInterface, PreAddUpdateAwareInterface
{
    use SetKeyFromValueTrait;

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
