<?php

declare(strict_types=1);

namespace App\Provider;

use Knp\Component\Pager\PaginatorInterface;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Product\ProductCategoryListing;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Resolver\DefaultDataResolver;
use Pimcore\Model\DataObject\ProductCategory;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements DataProviderInterface<ProductCategoryListing>
 */
#[DataProvider(ProductCategoryListing::class, DefaultDataResolver::class, 10)]
final readonly class PimcoreProductCategoryListingProvider implements DataProviderInterface
{
    public function __construct(
        private PaginatorInterface $paginator,
        private RequestStack $requestStack,
    ) {}

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
    public function get(string $className, mixed $data = null): ?ProductCategoryListing
    {
        $id = $data['id'] ?? null;

        if ($id === null) {
            return null;
        }

        $page = $this->requestStack->getMainRequest()?->query->getInt('page', 1) ?? 1;
        $limit = $this->requestStack->getMainRequest()?->query->getInt('limit', 10) ?? 10;
        $listing = (new ProductCategory\Listing())->setCondition("parentId = ?", [$id]);

        return new ProductCategoryListing($this->paginator->paginate($listing, $page, $limit));
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function save(mixed $dto, mixed $data = null): void
    {
        // TODO: Implement save() method.
    }
}
