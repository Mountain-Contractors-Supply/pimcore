<?php

declare(strict_types=1);

namespace App\Provider\Product;

use App\Dto\Product\ProductSearchArray;
use App\LinkGenerator\ProductLinkGenerator;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\OnlineStore\OnlineStoreInterface;
use McSupply\EcommerceBundle\Dto\Product\ProductSearchSuggestion;
use McSupply\EcommerceBundle\Dto\Product\ProductSearchSuggestionArray;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareTrait;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Bundle\GenericDataIndexBundle\Service\Search\SearchService\DataObject\DataObjectSearchServiceInterface;
use Pimcore\Bundle\GenericDataIndexBundle\Service\Search\SearchService\SearchProviderInterface;
use Pimcore\Model\DataObject\Product;
use Pimcore\Model\DataObject\ProductCategory;

/**
 * @implements DataProviderInterface<ProductSearchSuggestionArray>
 * @implements ReadOperationInterface<ProductSearchSuggestionArray>
 */
#[DataProvider(ProductSearchSuggestionArray::class, 10)]
final class PimcoreProductSearchSuggestionArrayProvider implements DataProviderInterface, ReadOperationInterface, DataResolverAwareInterface
{
    use DataResolverAwareTrait;

    public function __construct(
        private readonly ProductLinkGenerator $productLinkGenerator,
    ) {}

    public function supports(string $className, array $data = []): bool
    {
        return true;
    }

    public function get(string $className, array $data = []): ProductSearchSuggestionArray
    {
        $data['limit'] = 6;
        $items = $this->dataResolver->get(ProductSearchArray::class, $data);

        /** @var OnlineStoreInterface $onlineStore */
        $onlineStore = $this->dataResolver->get(OnlineStoreInterface::class);

        /** @var ProductCategory $rootCategory */
        $rootCategory = $onlineStore->getRootProductCategory();
        $path = $rootCategory->getPath() . $rootCategory->getKey() . '/';
        $query = $data['q'];
        $productCategoryGenerator = (function () use ($items, $query, $path): \Generator {
            foreach ($items as $item) {
                $indexData = $item->getSearchIndexData();
                $category = ProductCategory::getById($indexData['custom_fields']['category_ids'][0]);
                $name = str_replace([$path, '/'], ['', ' > '], (string)$category?->getPath());

                yield new ProductSearchSuggestion(
                    $indexData['standard_fields']['name']['en_US'],
                    '',
                    $this->productLinkGenerator->generate(
                        (new Product())
                            ->setProductId($indexData['standard_fields']['productId'])
                            ->setName($indexData['standard_fields']['name']['en_US']),
                    ),
                    $name . (string)$category?->getName(),
                    '/category/search?id=' . (int)$category?->getId() . '&q=' . $query,
                );
            }
        })();

        return new ProductSearchSuggestionArray($productCategoryGenerator);
    }
}
