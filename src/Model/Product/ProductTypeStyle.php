<?php

declare(strict_types=1);

namespace App\Model\Product;

use McSupply\EcommerceBundle\Dto\Product\ProductTypeInterface;
use Pimcore\Model\Element\AdminStyle;
use Pimcore\Model\Element\ElementInterface;

class ProductTypeStyle extends AdminStyle
{
    /**
     * @param ElementInterface $element
     */
    public function __construct(ElementInterface $element)
    {
        parent::__construct($element);

        if ($element instanceof ProductTypeInterface) {
            $this->elementIconClass = false;
            $this->elementIcon = $element->getIcon();
        }
    }
}
