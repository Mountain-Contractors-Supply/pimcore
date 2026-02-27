<?php

declare(strict_types=1);

namespace App\Provider;

use Exception;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Dto\Product\ProductInterface;
use McSupply\EcommerceBundle\Resolver\DefaultDataResolver;
use Pimcore\Model\DataObject\Product;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements DataProviderInterface<ProductInterface>
 */
#[DataProvider(ProductInterface::class, DefaultDataResolver::class, 10)]
final readonly class PimcoreProductProvider implements DataProviderInterface
{
    public function __construct(
        private RequestStack $requestStack,
    ) {}

    /**
     * @inheritDoc
     */
    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        $route = $this->requestStack->getMainRequest()?->attributes->get('_route');

        return in_array($route, ['product_detail', 'cart', 'cart_list_partial']);
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function get(string $className, mixed $data = null): ?ProductInterface
    {
        $productId = $data['productId'] ?? null;

        if ($productId === null) {
            return null;
        }

        $product = Product::getByProductId($productId, 1);

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
