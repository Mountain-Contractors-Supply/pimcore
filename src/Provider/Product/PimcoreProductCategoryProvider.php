<?php

declare(strict_types=1);

namespace App\Provider\Product;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Product\ProductCategoryInterface;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Resolver\DefaultDataResolver;
use Pimcore\Model\DataObject\ProductCategory;

/**
 * @implements DataProviderInterface<ProductCategoryInterface>
 */
#[DataProvider(ProductCategoryInterface::class, DefaultDataResolver::class, 10)]
final readonly class PimcoreProductCategoryProvider implements DataProviderInterface
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

    #[\Override]
    public function save(mixed $dto, mixed $data = null): void
    {
    }
}
