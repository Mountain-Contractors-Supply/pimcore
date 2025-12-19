<?php

namespace Pimcore\Bundle\EcommerceFrameworkBundle\Model;

use App\Model\AbstractModel;

// This is a temporary bridge class that serves for compatibility until properly updating dependencies
class AbstractProduct extends AbstractModel
{
    public function getOSProductNumber(): ?string
    {
        return null;
    }

    public function getPriceSystemName(): string
    {
        return '';
    }

    public function isActive(bool $inProductList = false): bool
    {
        return true;
    }
}
