<?php

namespace Pimcore\Bundle\EcommerceFrameworkBundle\Model;

use App\Model\AbstractModel;

// This is a temporary bridge class that serves for compatibility until properly updating dependencies
abstract class AbstractProduct extends AbstractModel
{
    public abstract function getOSProductNumber(): ?string;
    public abstract function getPriceSystemName(): string;
    public abstract function isActive(bool $inProductList = false): bool;
}
