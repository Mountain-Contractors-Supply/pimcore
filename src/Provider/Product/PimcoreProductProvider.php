<?php

declare(strict_types=1);

namespace App\Provider\Product;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Product\ProductInterface;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\Product;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements DataProviderInterface<ProductInterface>
 * @implements ReadOperationInterface<ProductInterface>
 */
#[DataProvider(ProductInterface::class, 10)]
final readonly class PimcoreProductProvider implements DataProviderInterface, ReadOperationInterface
{
    public function __construct(
        private RequestStack $requestStack,
    ) {}

    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        $route = $this->requestStack->getMainRequest()?->attributes->get('_route');

        return in_array($route, ['product_detail', 'cart', 'cart_list_partial']);
    }

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
}
