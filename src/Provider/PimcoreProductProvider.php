<?php

declare(strict_types=1);

namespace App\Provider;

use Exception;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Dto\Product\ProductInterface;
use McSupply\EcommerceBundle\Resolver\DefaultDataResolver;
use Pimcore\Model\DataObject\Product;

/**
 * @implements DataProviderInterface<ProductInterface>
 */
#[DataProvider(ProductInterface::class, DefaultDataResolver::class, 10)]
final readonly class PimcoreProductProvider implements DataProviderInterface
{
    /**
     * @inheritDoc
     */
    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function get(string $className, mixed $data = null): ?ProductInterface
    {
        if (!isset($data['productId'])) {
            return null;
        }

        $product = Product::getByProductId($data['productId']);

        return $product instanceof ProductInterface ? $product : null;
    }

    /**
     * @param Product $dto
     * @inheritDoc
     * @throws Exception
     */
    #[\Override]
    public function save(mixed $dto, mixed $data = null): void
    {
        $dto->save();
    }
}
