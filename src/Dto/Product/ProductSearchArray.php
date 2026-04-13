<?php

declare(strict_types=1);

namespace App\Dto\Product;

use McSupply\EcommerceBundle\Dto\AbstractArray;
use Pimcore\Bundle\GenericDataIndexBundle\Model\Search\DataObject\SearchResult\DataObjectSearchResultItem;

final class ProductSearchArray extends AbstractArray
{
    public function getType(): string
    {
        return DataObjectSearchResultItem::class;
    }
}
