<?php

declare(strict_types=1);

namespace App\Provider\Product;

use Knp\Component\Pager\PaginatorInterface;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Product\ProductCategoryInterface;
use McSupply\EcommerceBundle\Dto\Product\ProductCategoryListing;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\ProductCategory;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements DataProviderInterface<ProductCategoryListing>
 * @implements ReadOperationInterface<ProductCategoryListing>
 */
#[DataProvider(ProductCategoryListing::class, 10)]
final readonly class PimcoreProductCategoryListingProvider implements DataProviderInterface, ReadOperationInterface
{
    public function __construct(
        private PaginatorInterface $paginator,
        private RequestStack $requestStack,
    ) {}

    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        return true;
    }

    #[\Override]
    public function get(string $className, mixed $data = null): ?ProductCategoryListing
    {
        $id = $data['id'] ?? null;

        if ($id === null) {
            return null;
        }

        $page = $this->requestStack->getMainRequest()?->query->getInt('page', 1) ?? 1;
        $limit = $this->requestStack->getMainRequest()
            ?->query->getInt('limit', ProductCategoryInterface::DEFAULT_PER_PAGE_COUNT) ??
            ProductCategoryInterface::DEFAULT_PER_PAGE_COUNT;
        $listing = (new ProductCategory\Listing())->setCondition("parentId = ?", [$id]);

        return new ProductCategoryListing($this->paginator->paginate($listing, $page, $limit));
    }
}
