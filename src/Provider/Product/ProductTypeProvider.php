<?php

declare(strict_types=1);

namespace App\Provider\Product;

use Exception;
use McSupply\EcommerceBundle\Provider\Product\ProductTypeProviderInterface;
use Pimcore\Model\DataObject\ProductType;

final readonly class ProductTypeProvider implements ProductTypeProviderInterface
{
    /**
     * @inheritDoc
     * @throws Exception
     */
    #[\Override]
    public function getProductTypes(): array
    {
        return ProductType::getList()->getData();
    }
}
