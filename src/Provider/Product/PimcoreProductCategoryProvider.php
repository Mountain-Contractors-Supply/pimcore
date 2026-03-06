<?php

declare(strict_types=1);

namespace App\Provider\Product;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Product\ProductCategoryInterface;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\ProductCategory;

/**
 * @implements DataProviderInterface<ProductCategoryInterface>
 * @implements ReadOperationInterface<ProductCategoryInterface>
 */
#[DataProvider(ProductCategoryInterface::class, 10)]
final readonly class PimcoreProductCategoryProvider implements DataProviderInterface, ReadOperationInterface
{
    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        return true;
    }

    #[\Override]
    public function get(string $className, mixed $data = null): ?ProductCategoryInterface
    {
        if (!isset($data['id'])) {
            return null;
        }

        $productCategory = ProductCategory::getById((int)$data['id']);

        return $productCategory instanceof ProductCategoryInterface ? $productCategory : null;
    }
}
