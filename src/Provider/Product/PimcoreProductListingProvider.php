<?php

declare(strict_types=1);

namespace App\Provider\Product;

use Knp\Component\Pager\PaginatorInterface;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Product\ProductInterface;
use McSupply\EcommerceBundle\Dto\Product\ProductListing;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\Product;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements DataProviderInterface<ProductListing>
 * @implements ReadOperationInterface<ProductListing>
 */
#[DataProvider(ProductListing::class, 10)]
final readonly class PimcoreProductListingProvider implements DataProviderInterface, ReadOperationInterface
{
    public function __construct(
        private PaginatorInterface $paginator,
        private RequestStack $requestStack,
    ) {}

    #[\Override]
    public function supports(string $className, array $data = []): bool
    {
        return true;
    }

    #[\Override]
    public function get(string $className, array $data = []): ?ProductListing
    {
        
        $mainRequest = $this->requestStack->getMainRequest();
        $id = $data['id'] ?? $mainRequest?->query->getInt('id');
        $query = $mainRequest?->query->getString('q');

        if ($id === null && empty($query)) {
            return null;
        }

        $page = $mainRequest?->query->getInt('page', 1) ?? 1;
        $limit = $mainRequest?->query->getInt('limit',
            ProductInterface::DEFAULT_PER_PAGE_COUNT) ?? ProductInterface::DEFAULT_PER_PAGE_COUNT;
        $listing = new Product\Listing();
        $conditions = [];
        $params = [];

        if ($id !== null) {
            $conditions[] = 'oo_id IN (SELECT src_id FROM object_relations_product WHERE dest_id = ? AND fieldname = ?)';
            $params[] = $id;
            $params[] = 'categoriesRef';
        }

        if (!empty($query)) {
            $conditions[] = '(name LIKE ?)';
            $like = '%' . $query . '%';
            $params[] = $like;
        }

        $listing->setCondition(
            implode(' AND ', $conditions),
            $params
        );

        return new ProductListing($this->paginator->paginate($listing, $page, $limit));
    }
}
