<?php

declare(strict_types=1);

namespace App\Provider;

use McSupply\EcommerceBundle\Dto\Product\ProductInterface;
use McSupply\EcommerceBundle\Provider\ProductProviderInterface;
use Pimcore\Model\DataObject\Product;

final readonly class ProductProvider implements ProductProviderInterface
{
    /**
     * @inheritDoc
     */
    #[\Override]
    public function getProduct(string $productId): ?ProductInterface
    {
        return Product::getByProductId($productId, 1);
    }
}
