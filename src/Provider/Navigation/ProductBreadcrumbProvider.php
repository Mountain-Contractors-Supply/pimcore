<?php

declare(strict_types=1);

namespace App\Provider\Navigation;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Navigation\Breadcrumb;
use McSupply\EcommerceBundle\Dto\Navigation\Link;
use McSupply\EcommerceBundle\Dto\Product\ProductInterface;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Resolver\DataResolverAwareInterface;
use McSupply\EcommerceBundle\Resolver\DataResolverAwareTrait;
use McSupply\EcommerceBundle\Resolver\DefaultDataResolver;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements DataProviderInterface<Breadcrumb>
 */
#[DataProvider(Breadcrumb::class, DefaultDataResolver::class, 10)]
final class ProductBreadcrumbProvider implements DataProviderInterface, DataResolverAwareInterface
{
    use DataResolverAwareTrait;

    public function __construct(
        private readonly RequestStack $requestStack,
    ) {}

    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        return $this->requestStack->getMainRequest()?->attributes->get('_route') === 'product_detail';
    }

    #[\Override]
    public function get(string $className, mixed $data = null): Breadcrumb
    {
        $breadcrumbs = new Breadcrumb();
        $product = $this->dataResolver->get(ProductInterface::class, [
            'productId' => $this->requestStack->getMainRequest()?->attributes->get('product'),
        ]);

        $breadcrumbs->add(new Link((string)$product->getName()));

        return $breadcrumbs;
    }

    #[\Override]
    public function save(mixed $dto, mixed $data = null): void
    {
    }
}
