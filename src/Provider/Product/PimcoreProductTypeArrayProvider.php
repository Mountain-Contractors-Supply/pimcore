<?php

declare(strict_types=1);

namespace App\Provider\Product;

use Exception;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Product\ProductTypeArray;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\ProductType;

/**
 * @implements DataProviderInterface<ProductTypeArray>
 * @implements ReadOperationInterface<ProductTypeArray>
 */
#[DataProvider(ProductTypeArray::class, 10)]
class PimcoreProductTypeArrayProvider implements DataProviderInterface, ReadOperationInterface
{
    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        return true;
    }

    /**
     * @throws Exception
     */
    #[\Override]
    public function get(string $className, mixed $data = null): mixed
    {
        $productTypes = new ProductTypeArray();

        foreach (ProductType::getList() as $productType) {
            if (!$productType) {
                continue;
            }

            $productTypes->add($productType, $productType->getProductTypeId());
        }

        return $productTypes;
    }
}
