<?php

declare(strict_types=1);

namespace App\Provider\Product;

use Knp\Component\Pager\PaginatorInterface;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Product\ProductInterface;
use McSupply\EcommerceBundle\Dto\Product\ProductListing;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareTrait;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\Product;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements DataProviderInterface<ProductListing>
 * @implements ReadOperationInterface<ProductListing>
 */
#[DataProvider(ProductListing::class, 10)]
final class PimcoreProductListingProvider implements DataProviderInterface, ReadOperationInterface, DataResolverAwareInterface
{
    use DataResolverAwareTrait;

    public function __construct(
        private readonly PaginatorInterface $paginator,
        private readonly RequestStack $requestStack,
    ) {}

    #[\Override]
    public function supports(string $className, array $data = []): bool
    {
        return true;
    }

    #[\Override]
    public function get(string $className, array $data = []): ProductListing
    {
        $mainRequest = $this->requestStack->getMainRequest();
        $data['id'] ??= $mainRequest?->query->getInt('id');
        $data['q'] ??= $mainRequest?->query->getString('q');
        $listing = $this->dataResolver->get(Product\Listing::class, $data);
        $page = $mainRequest?->query->getInt('page', 1) ?? 1;
        $limit = $mainRequest?->query->getInt('limit',
            ProductInterface::DEFAULT_PER_PAGE_COUNT) ?? ProductInterface::DEFAULT_PER_PAGE_COUNT;

        return new ProductListing($this->paginator->paginate($listing, $page, $limit));
    }
}
